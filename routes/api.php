<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SurveyController;
use App\Http\Controllers\Api\V1\ResponseController;
use App\Http\Controllers\Api\V1\ApiKeyController;
use App\Http\Controllers\PublicStatsController;


// Public Stats & Chatbot (No Auth Required)
Route::get('/public/stats', [PublicStatsController::class , 'index']);
Route::post('/public/chatbot', [PublicStatsController::class , 'chatbot']);

Route::prefix('v1')->name('api.v1.')->group(function () {
    // API Index
    Route::get('/', function () {
            return response()->json([
            'name' => 'SurveyCore API',
            'version' => 'v1',
            'status' => 'active',
            'endpoints' => [
            'auth' => '/api/v1/auth',
            'surveys' => '/api/v1/surveys',
            ],
            ]);
        }
        );

        // Public Auth
        Route::post('/auth/register', [AuthController::class , 'register']);
        Route::post('/auth/login', [AuthController::class , 'login']);
        Route::post('/auth/forgot-password', [AuthController::class , 'forgotPassword']);
        Route::post('/auth/reset-password', [AuthController::class , 'resetPassword']);

        // Public Survey Routes (Read-Only)
        Route::get('surveys/{survey}', [SurveyController::class , 'show'])->name('surveys.show');

        // Protected Routes
        Route::middleware('auth:api')->group(function () {
            // Auth Management
            Route::post('/auth/logout', [AuthController::class , 'logout']);
            Route::get('/auth/user', [AuthController::class , 'user']);
            Route::post('/auth/refresh', [AuthController::class , 'refresh']);
            Route::post('/auth/verify-email', [AuthController::class , 'verifyEmail']);

            // 2FA
            Route::post('/auth/2fa/enable', [AuthController::class , 'enable2fa']);
            Route::post('/auth/2fa/verify', [AuthController::class , 'verify2fa']);

            // Surveys (Management)
            Route::apiResource('surveys', SurveyController::class)->except(['show']);
            Route::get('surveys/{survey}/analytics', [SurveyController::class , 'analytics']);
            Route::get('surveys/{survey}/export', [SurveyController::class , 'export']);

            // Survey Responses (Admin)
            Route::get('surveys/{survey}/responses', [ResponseController::class , 'index'])->name('surveys.responses.index');
            Route::post('surveys/{survey}/responses', [ResponseController::class , 'store'])->name('surveys.responses.store');

            // API Management
            Route::apiResource('api-keys', ApiKeyController::class);
        }
        );

        // Public Survey Submissions (with HMAC/RateLimit)
        Route::middleware(['api.rate_limit', 'api.hmac'])->group(function () {
            Route::post('surveys/{survey}/submit', [ResponseController::class , 'submit'])->name('surveys.submit');
            // Fallback for GET request on submit (User Friendliness)
            Route::get('surveys/{survey}/submit', function () {
                    return response()->json(['success' => false, 'message' => 'Method GET not allowed. Please use POST to submit answers.'], 405);
                }
                );
            }
            );
        });