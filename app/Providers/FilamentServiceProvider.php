<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Contracts\View\View;
use Filament\Panel;

class FilamentServiceProvider extends ServiceProvider
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
     */
    public function boot(): void
    {
        // Set RTL globally for Filament
        Panel::configureUsing(function (Panel $panel): void {
            $panel->rtl(true);
        });

        // Add custom RTL styles
        FilamentAsset::register([
            Css::make('custom-rtl', __DIR__ . '/../../resources/css/filament-rtl.css'),
        ]);

        // Affect all views rendered by Filament
        FilamentView::registerRenderHook(
            'panels::body.start',
            fn (): View => view('filament.custom.body-start'),
        );
    }
}
