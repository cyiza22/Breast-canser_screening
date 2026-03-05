<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MLService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('ML_SERVICE_URL', 'http://localhost:8001');
    }

    public function predict(string $filePath): ?array
    {
        // Verify file exists before sending
        if (!file_exists($filePath)) {
            Log::error('MLService: file not found', ['path' => $filePath]);
            return null;
        }

        try {
            $response = Http::timeout(30)
                ->attach('file', file_get_contents($filePath), basename($filePath))
                ->post("{$this->baseUrl}/predict");

            if ($response->successful()) {
                return $response->json();
            }

            // Log the actual FastAPI error
            Log::error('MLService: predict failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('MLService: exception', ['message' => $e->getMessage()]);
            return null;
        }
    }
}