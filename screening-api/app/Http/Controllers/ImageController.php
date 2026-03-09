<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Services\MLService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function predict(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:10240',
            ]);

            $imageFile = $request->file('image');
            $mlService = new MLService(); 
            
            $result = $mlService->predict($imageFile->getRealPath());

            if (!$result) {
                return response()->json([
                    'error' => 'ML service unavailable',
                    'fallback' => 'Please try again later or use the questionnaire.'
                ], 503);
            }

            // Save to history
            Prediction::create([
                'user_id' => auth()->id(),
                'type' => 'image',
                'result' => json_encode($result),
            ]);

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Prediction failed', ['error' => $e->getMessage()]);
            
            return response()->json([
                'error' => 'Prediction failed',
                'message' => 'Please try again with a clearer image'
            ], 500);
        }
    }
}