<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MLService;
use App\Services\ChatService;
use App\Models\Prediction;

class AssistController extends Controller
{
    public function assist(Request $request, MLService $ml, ChatService $chat)
    {
        $prediction = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads');
            $prediction = $ml->predict(storage_path("app/".$path));
        }

        $response = $chat->generate(
            $request->message,
            $prediction
        );

        if ($prediction) {
            Prediction::create([
                'user_id' => auth()->id(),
                'result' => json_encode($prediction)
            ]);
        }

        return response()->json([
            'prediction' => $prediction,
            'response' => $response
        ]);
    }
}
