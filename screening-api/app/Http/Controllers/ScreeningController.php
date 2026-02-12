<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScreeningController extends Controller
{
    public function predict(Request $request)
    {
        $response = Http::attach(
            'file',
            file_get_contents($request->file('image')),
            'image.jpg'
        )->post('http://127.0.0.1:8000/predict');

        return $response->json();
    }

    public function chat(Request $request)
    {
        $response = Http::post(
            'http://127.0.0.1:8000/chat',
            ['message'=>$request->message]
        );

        return $response->json();
    }
}

