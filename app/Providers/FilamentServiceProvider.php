<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

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
