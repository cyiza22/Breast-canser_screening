<?php

namespace App\Services;

class ChatService
{
    /**
     * Knowledge base for common breast cancer questions.
     */
    private array $knowledge = [
        'self_exam' => [
            'keywords' => ['self exam', 'self-exam', 'check myself', 'examine', 'how to check'],
            'response' => 'To do a breast self-exam: (1) Stand in front of a mirror with arms raised and look for changes in shape, skin dimpling, or nipple changes. (2) While lying down, use the pads of your three middle fingers to feel the entire breast in small circular motions. (3) Check the area from your collarbone to below the breast, and from your armpit to the centre of your chest. Do this monthly, ideally a few days after your period ends.',
        ],
        'symptoms' => [
            'keywords' => ['signs', 'symptoms', 'warning', 'early signs', 'what to look for'],
            'response' => 'Early signs of breast cancer include: a new lump or thickening in the breast or underarm, change in breast size or shape, skin dimpling or puckering, nipple turning inward, nipple discharge (especially if bloody), and redness or flaky skin on the breast. If you notice any of these, please see a health professional promptly.',
        ],
        'risk_factors' => [
            'keywords' => ['risk', 'causes', 'why', 'risk factor', 'chance'],
            'response' => 'Key risk factors include: being female, increasing age (especially over 50), family history of breast cancer, early menstruation (before age 12), late first pregnancy (after 30), never having given birth, previous breast biopsies, and obesity. Having risk factors does not mean you will get cancer — it means you should be more vigilant about screening.',
        ],
        'screening' => [
            'keywords' => ['screening', 'mammogram', 'when to screen', 'how often'],
            'response' => 'Screening recommendations: women aged 25-39 should have a clinical breast exam every 1-3 years. Women 40 and older should have annual mammograms where available. Monthly self-exams are recommended for all women over 20. In settings where mammography is not available, clinical breast exams and self-exams remain valuable tools for early detection.',
        ],
        'treatment' => [
            'keywords' => ['treatment', 'cure', 'treatable', 'survive', 'survival'],
            'response' => 'Breast cancer is highly treatable when detected early. Treatment options include surgery, chemotherapy, radiation therapy, hormone therapy, and targeted therapy. Early-stage breast cancer has a survival rate above 90% in many settings. The most important step is early detection — the sooner it is found, the more treatment options are available.',
        ],
    ];

    /**
     * Generate a response based on user message and optional prediction context.
     */
    public function generate(?string $message, $prediction = null): string
    {
        $response = '';

        // If there's a risk assessment result, give contextual advice
        if ($prediction && isset($prediction['risk_level'])) {
            $level = $prediction['risk_level'];
            $score = $prediction['risk_score'] ?? 'N/A';

            $response = match ($level) {
                'high' => "Your risk assessment indicates a HIGH risk level (score: {$score}). "
                    . "This does not mean you have cancer, but we strongly recommend visiting "
                    . "a health facility for a clinical breast examination as soon as possible. "
                    . "Please contact your Community Health Worker for a referral.",

                'moderate' => "Your risk assessment indicates a MODERATE risk level (score: {$score}). "
                    . "We recommend scheduling a clinical breast examination within the next month. "
                    . "Continue doing monthly self-exams and note any changes.",

                'low' => "Your risk assessment indicates a LOW risk level (score: {$score}). "
                    . "This is a positive result. Continue with monthly self-examinations "
                    . "and routine screenings as recommended for your age group.",

                default => "Your screening is complete. Please consult a healthcare professional "
                    . "for a full clinical evaluation.",
            };

            // Add disclaimer
            $response .= "\n\nReminder: This is a preliminary screening tool and not a medical diagnosis.";

            return $response;
        }

        // Match user message against knowledge base
        if ($message) {
            $messageLower = strtolower($message);

            foreach ($this->knowledge as $topic) {
                foreach ($topic['keywords'] as $keyword) {
                    if (str_contains($messageLower, $keyword)) {
                        return $topic['response'];
                    }
                }
            }

            // Greeting
            if (preg_match('/^(hi|hello|hey|good morning|good afternoon)/i', $message)) {
                return "Hello! I'm your breast health assistant. You can ask me about "
                    . "breast self-exams, symptoms to watch for, risk factors, screening "
                    . "guidelines, or treatment options. How can I help you today?";
            }
        }

        // Default
        return "I can help with breast cancer information. Try asking about: "
            . "how to do a self-exam, early warning signs, risk factors, "
            . "screening recommendations, or treatment options.";
    }
}