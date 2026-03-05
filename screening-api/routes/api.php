<?php

use App\Http\Controllers\AssistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ScreeningController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Public
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

// Protected
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    // Questionnaire-based risk assessment
    Route::post('/screen', [ScreeningController::class, 'assess']);
    // Screening history
    Route::get('/screenings', [ScreeningController::class, 'history']);
    //  chat assistant (existing)
    Route::post('/assist', [AssistController::class, 'assist']);
    // image endpoint
    Route::post('/predict', [ImageController::class, 'predict']);
    // Health check
    Route::get('/health', [HealthController::class, 'check']);

    Route::delete('/screenings/{id}', [ScreeningController::class, 'destroy']);
    Route::delete('/screenings', [ScreeningController::class, 'clearAll']);
});