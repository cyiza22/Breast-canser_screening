<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AssistController extends Controller
{
    public function assist(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = trim($request->message);
        $mlServiceUrl = env('ML_SERVICE_URL', 'https://breast-canserscreening-production-950a.up.railway.app');

        // Cache common questions for 1 hour
        // Normalize: lowercase + trim for better cache hits
        $cacheKey = 'assist_' . md5(strtolower($message));

        $result = Cache::remember($cacheKey, 60 * 60, function () use ($message, $mlServiceUrl) {
            try {
                $response = Http::timeout(30)->post("{$mlServiceUrl}/assist", [
                    'message' => $message,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                // Fall through to fallback
            }

            // Fallback: keyword-based responses when ML service is down
            return $this->fallbackResponse($message);
        });

        return response()->json($result);
    }

    private function fallbackResponse(string $message): array
    {
        $lower = strtolower($message);

        $responses = [
            'symptom' => [
                'keywords' => ['symptom', 'sign', 'lump', 'pain', 'discharge', 'change'],
                'reply'    => 'Common breast cancer symptoms include: a new lump or mass, swelling, skin dimpling, nipple discharge, or skin redness. If you notice any changes, please consult a healthcare professional promptly.',
            ],
            'screening' => [
                'keywords' => ['screen', 'mammogram', 'check', 'test', 'detect', 'exam'],
                'reply'    => 'Regular screening is key to early detection. Women aged 40+ should consider annual mammograms. Self-exams can be done monthly at home. Our app helps with preliminary risk assessment, but always follow up with a doctor.',
            ],
            'risk' => [
                'keywords' => ['risk', 'chance', 'likely', 'prevent', 'reduce', 'factor'],
                'reply'    => 'Key risk factors include: age (40+), family history, early menstruation, late menopause, and obesity. You can reduce risk through regular exercise, healthy diet, limiting alcohol, and maintaining a healthy weight.',
            ],
            'treatment' => [
                'keywords' => ['treat', 'cure', 'surgery', 'chemo', 'radiation', 'therapy'],
                'reply'    => 'Treatment options depend on the type and stage. They may include surgery, radiation therapy, chemotherapy, hormone therapy, or targeted therapy. Early detection greatly improves outcomes. Please consult an oncologist for personalized advice.',
            ],
            'self_exam' => [
                'keywords' => ['self', 'how to', 'examine', 'myself', 'home'],
                'reply'    => 'For a breast self-exam: 1) Stand before a mirror and look for changes in shape or skin. 2) Raise arms and check again. 3) Lying down, use your right hand to examine the left breast in circular motions. 4) Repeat for the other side. 5) Check for nipple discharge. Do this monthly.',
            ],
        ];

        foreach ($responses as $category) {
            foreach ($category['keywords'] as $keyword) {
                if (str_contains($lower, $keyword)) {
                    return [
                        'reply'  => $category['reply'],
                        'source' => 'fallback_cache',
                    ];
                }
            }
        }

        return [
            'reply'  => 'Thank you for your question. For the most accurate medical advice, please consult a healthcare professional. Our app can help with preliminary risk assessment through the questionnaire or image analysis features.',
            'source' => 'fallback_default',
        ];
    }
}