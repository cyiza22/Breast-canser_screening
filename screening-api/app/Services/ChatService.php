<?php

namespace App\Services;

class ChatService
{
    public function generate($message, $prediction)
    {
        if ($prediction) {
            return "Risk score: ".$prediction['risk_score'].
                   ". Consult a medical professional.";
        }

        if (str_contains(strtolower($message), "breast cancer")) {
            return "Breast cancer is abnormal growth of breast cells.";
        }

        return "How can I help you?";
    }
}
