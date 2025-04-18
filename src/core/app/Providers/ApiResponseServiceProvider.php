<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    // public function register(): void
    // {
    //     //
    // }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('error', function ($status, $message) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'content' => []
            ]);
        });
    }
}
