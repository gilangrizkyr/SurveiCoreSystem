<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/s/{uuid}', [App\Http\Controllers\PublicSurveyController::class , 'show'])->name('public.survey.show');
Route::post('/s/{uuid}', [App\Http\Controllers\PublicSurveyController::class , 'store'])->name('public.survey.store');