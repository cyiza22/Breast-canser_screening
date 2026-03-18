<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MLService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('ML_SERVICE_URL', 'https://breast-canserscreening-production-950a.up.railway.app');
        Log::info('MLService initialized', ['baseUrl' => $this->baseUrl]);
    }

    public function predict(string $filePath): ?array
    {
        try {
            Log::info('MLService::predict() called', ['filePath' => $filePath]);

            // Verify file exists
            if (!file_exists($filePath)) {
                Log::error('MLService: File does not exist', ['path' => $filePath]);
                return null;
            }

            $fileSize = filesize($filePath);
            Log::info('File verified', ['size' => $fileSize]);

            if ($fileSize === 0) {
                Log::error('MLService: File is empty', ['path' => $filePath]);
                return null;
            }

            // Read file contents
            $fileContents = file_get_contents($filePath);
            if ($fileContents === false) {
                Log::error('MLService: Could not read file', ['path' => $filePath]);
                return null;
            }

            $mlUrl = "{$this->baseUrl}/predict";
            Log::info('Sending file to ML service', [
                'ml_url' => $mlUrl,
                'file_size' => strlen($fileContents),
            ]);

            // Make request to ML service
            $response = Http::timeout(60)
                ->attach('file', $fileContents, basename($filePath))
                ->post($mlUrl);

            Log::info('ML service response received', [
                'status' => $response->status(),
                'body' => substr($response->body(), 0, 500), // First 500 chars
            ]);

            if (!$response->successful()) {
                Log::error('MLService: Prediction failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $result = $response->json();
            Log::info('MLService: Prediction successful', ['result' => $result]);
            
            return $result;

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('MLService: Connection error', [
                'message' => $e->getMessage(),
            ]);
            return null;

        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('MLService: Request error', [
                'message' => $e->getMessage(),
                'status' => $e->response?->status(),
                'body' => $e->response?->body(),
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('MLService: Unexpected error', [
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return null;
        }
    }
}
