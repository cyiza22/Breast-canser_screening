<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Prediction;

class ScreeningController extends Controller
{
    /**
     * Submit clinical questionnaire for risk assessment.
     */
    public function assess(Request $request)
    {
        $validated = $request->validate([
            'age'              => 'required|integer|min:18|max:100',
            'family_history'   => 'required|in:none,distant,mother_sister,multiple',
            'age_first_period' => 'required|integer|min:8|max:20',
            'age_first_birth'  => 'required|in:before_20,20_to_29,after_30,no_children',
            'previous_biopsy'  => 'required|in:yes,no',
            'lump_detected'    => 'required|in:yes,no',
            'skin_changes'     => 'required|in:yes,no',
            'nipple_discharge' => 'required|in:yes,no',
            'breast_pain'      => 'required|in:yes,no',
        ]);

        // Call the FastAPI ML service
        $mlServiceUrl = env('ML_SERVICE_URL', 'http://localhost:8001');

        try {
            $response = Http::timeout(30)->post("{$mlServiceUrl}/assess", $validated);
            $result = $response->json();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'ML service unavailable. Please try again later.',
            ], 503);
        }

        // Store the prediction
        Prediction::create([
            'user_id' => auth()->id(),
            'type'    => 'questionnaire',
            'result'  => json_encode($result),
        ]);

        return response()->json($result);
    }

    /**
     * Get screening history for the authenticated user.
     */
    public function history(Request $request)
    {
        $predictions = Prediction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($p) {
                return [
                    'id'         => $p->id,
                    'type'       => $p->type ?? 'image',
                    'result'     => json_decode($p->result, true),
                    'created_at' => $p->created_at->toDateTimeString(),
                ];
            });

        return response()->json(['screenings' => $predictions]);
    }
}