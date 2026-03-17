<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use Illuminate\Support\Facades\Request;

class AssistController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function assist(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'lang' => 'nullable|in:en,fr,rw' 
        ]);

        $lang = $request->lang ?? 'en';

        $message = trim($request->input('message'));
        
        // Generate response using ChatService
        $reply = $this->chatService->generate($message, null);

        return response()->json([
            'reply' => $reply,
            'source' => 'knowledge_base'
        ]);
    }
}
