<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
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
        Response::macro('success', function ($value) {
            return Response::json([
                "success" => true,
                "data" => $value,
            ]);
        });

        Response::macro('error', function (string|array $message, int $code = 500) {
            return Response::json([
                "success" => false,
                "message" => $message,
            ], $code);
        });
    }
}
