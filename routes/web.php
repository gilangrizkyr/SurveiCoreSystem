<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/changelog', function () {
    return view('changelog');
});

Route::get('/status', function () {
    return response()->json([
    'status' => 'operational',
    'code' => 200,
    'app_name' => 'DPMPTSP Survei System',
    'version' => '1.1.0',
    'timestamp' => now()->toIso8601String(),
    ]);
});

Route::get('/survey/{uuid}', [App\Http\Controllers\PublicSurveyController::class , 'show'])->name('public.survey.show');
Route::post('/survey/{uuid}', [App\Http\Controllers\PublicSurveyController::class , 'store'])->name('public.survey.store');

// Admin/Protected Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/docs/api', function () {
            $path = base_path('docs/API_DOCUMENTATION.md');
            if (!file_exists($path)) {
                abort(404, 'Documentation not found.');
            }
            return response()->file($path, ['Content-Type' => 'text/plain']);
        }
        )->name('docs.api');
    });