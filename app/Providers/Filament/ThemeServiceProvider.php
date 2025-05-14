<?php

namespace App\Providers\Filament;

use App\View\Components\KpiSummaryBar;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
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
        // Register custom theme CSS
        FilamentAsset::register([
            Css::make('nm-digitalhub-theme', __DIR__.'/../../../resources/css/filament/theme/theme.css'),
        ]);

        // Register custom components
        Blade::component('kpi-summary-bar', KpiSummaryBar::class);
    }
}
