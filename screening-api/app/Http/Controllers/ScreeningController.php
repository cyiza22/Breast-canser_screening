<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScreeningRequest;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ScreeningController extends Controller
{
    public function assess(ScreeningRequest $request)
    {
        
        $cacheKey = 'assess_' . md5(json_encode($request));

        $result = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($request) {
            $mlServiceUrl = env('ML_SERVICE_URL', 'https://breast-canserscreening-production-950a.up.railway.app');
            $response = Http::timeout(30)->post("{$mlServiceUrl}/assess", $request);

            if (!$response->successful()) {
                throw new \Exception('ML error: ' . $response->body());
            }
            return $response->json();
        });

        Prediction::create([
            'user_id' => auth()->id(),
            'type'    => 'questionnaire',
            'result'  => json_encode($result),
        ]);

        Cache::forget("history_" . auth()->id());

        return response()->json($result);
    }

    public function history(Request $request)
    {
        $userId = auth()->id();

        $predictions = Cache::remember("history_{$userId}", 30, function () use ($userId) {
            return Prediction::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get()
                ->map(function ($p) {
                    return [
                        'id'         => $p->id,
                        'type'       => $p->type ?? 'image',
                        'result'     => json_decode($p->result, true),
                        'created_at' => $p->created_at->toDateTimeString(),
                    ];
                });
        });

        return response()->json(['screenings' => $predictions]);
    }

    // Delete a single screening
    public function destroy(Request $request, $id)
    {
        $prediction = Prediction::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$prediction) {
            return response()->json(['message' => 'Screening not found.'], 404);
        }

        $prediction->delete();
        Cache::forget("history_" . auth()->id());

        return response()->json(['message' => 'Screening deleted.']);
    }

    // Clear all history
    public function clearAll(Request $request)
    {
        $count = Prediction::where('user_id', auth()->id())->count();
        Prediction::where('user_id', auth()->id())->delete();
        Cache::forget("history_" . auth()->id());

        return response()->json([
            'message' => "{$count} screening(s) deleted.",
            'count'   => $count,
        ]);
    }
}