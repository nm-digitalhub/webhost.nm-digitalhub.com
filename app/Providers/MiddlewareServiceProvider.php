<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsClient;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * This registers middleware for the Laravel 12+ architecture
     * where middleware is defined directly in routes or handled by
     * Livewire components.
     */
    public function boot(): void
    {
        // Register middleware aliases for use in route definitions
        Route::aliasMiddleware('role', RoleMiddleware::class);
        Route::aliasMiddleware('admin', IsAdmin::class);
        Route::aliasMiddleware('client', IsClient::class);

        // Register web middleware group additions
        Route::pushMiddlewareToGroup('web', SetLocale::class);
    }
}
