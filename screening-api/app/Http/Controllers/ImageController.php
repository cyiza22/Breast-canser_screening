<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Services\MLService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function predict(Request $request)
    {
        try {
            // Log the incoming request
            Log::info('=== Image Upload Started ===', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('image'),
                'files' => $request->files->keys(),
            ]);

            // Validate the image
            $validated = $request->validate([
                'image' => 'required|image|max:10240',
            ]);

            Log::info('Validation passed');

            $imageFile = $request->file('image');
            
            if (!$imageFile) {
                Log::error('No image file found after validation');
                return response()->json([
                    'error' => 'No image file received',
                ], 400);
            }

            Log::info('Image file details', [
                'name' => $imageFile->getClientOriginalName(),
                'size' => $imageFile->getSize(),
                'mime' => $imageFile->getMimeType(),
                'path' => $imageFile->getRealPath(),
            ]);

            // Call ML Service
            $mlService = new MLService();
            Log::info('Calling ML Service...');
            
            $result = $mlService->predict($imageFile->getRealPath());

            Log::info('ML Service returned', [
                'result' => $result,
            ]);

            if (!$result) {
                Log::warning('ML service returned null');
                return response()->json([
                    'error' => 'ML service unavailable',
                    'fallback' => 'Please try again later or use the questionnaire.'
                ], 503);
            }

            // Save to database
            Log::info('Saving prediction to database');
            
            $prediction = Prediction::create([
                'user_id' => auth()->id(),
                'type' => 'image',
                'result' => json_encode($result),
            ]);

            Log::info('=== Image Upload Complete ===', [
                'prediction_id' => $prediction->id,
            ]);

            return response()->json($result, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('VALIDATION ERROR', ['errors' => $e->errors()]);
            
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('=== PREDICTION ERROR ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'error' => 'Prediction failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
