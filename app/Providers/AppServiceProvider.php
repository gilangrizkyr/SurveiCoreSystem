<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\SurveyRepositoryInterface;
use App\Repositories\SurveyRepository;
use App\Repositories\Interfaces\ResponseRepositoryInterface;
use App\Repositories\ResponseRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class , UserRepository::class);
        $this->app->bind(SurveyRepositoryInterface::class , SurveyRepository::class);
        $this->app->bind(ResponseRepositoryInterface::class , ResponseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\SurveyResponse::observe(\App\Observers\SurveyResponseObserver::class);
    }
}