<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Prediction;

class ImageController extends Controller
{
    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $imageFile = $request->file('image');
        $mlServiceUrl = env('ML_SERVICE_URL', 'https://breast-canserscreening-production-950a.up.railway.app');

        // Cache key from image content hash (same image = same prediction)
        $imageHash = md5_file($imageFile->getRealPath());
        $cacheKey = 'predict_' . $imageHash;

        $result = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($imageFile, $mlServiceUrl) {
            $response = Http::timeout(60)
                ->attach(
                    'file',
                    file_get_contents($imageFile->getRealPath()),
                    $imageFile->getClientOriginalName()
                )
                ->post("{$mlServiceUrl}/predict");

            if (!$response->successful()) {
                throw new \Exception('ML error: ' . $response->body());
            }

            return $response->json();
        });

        // Always save to history
        Prediction::create([
            'user_id' => auth()->id(),
            'type'    => 'image',
            'result'  => json_encode($result),
        ]);

        return response()->json($result);
    }
}