<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        view()->share('formMethod', function ($method) {
            return in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']) ? 'POST' : $method;
        });
    }
}
