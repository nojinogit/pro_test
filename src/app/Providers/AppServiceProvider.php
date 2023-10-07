<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('image_url', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/\.(jpg|jpeg|png)$/i', $value);
        });

    }
}
