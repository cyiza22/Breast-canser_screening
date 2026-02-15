<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MLService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('ML_SERVICE_URL', 'http://localhost:8001');
    }

    /**
     * Send an image to the FastAPI ML service for prediction.
     */
    public function predict(string $filePath): ?array
    {
        try {
            $response = Http::timeout(30)
                ->attach('file', file_get_contents($filePath), basename($filePath))
                ->post("{$this->baseUrl}/predict");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            report($e);
            return null;
        }
    }
}