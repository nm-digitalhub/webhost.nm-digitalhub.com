<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?int $navigationSort = -2;

    public static function getNavigationLabel(): string
    {
        return 'Dashboard';
    }

    public static function getNavigationGroup(): ?string
    {
        return null;
    }

    public function getTitle(): string
    {
        return 'Dashboard';
    }

    public static function getSlug(): string
    {
        return 'dashboard';
    }
}

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestActivityWidget;
use App\Filament\Widgets\ModulesStatsWidget;
use App\Filament\Widgets\SystemHealthWidget;
use App\Filament\Widgets\SystemResourcesWidget;
use App\Filament\Widgets\UsersStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Contracts\View\View;

class Dashboard extends BaseDashboard
{
    // Override default widgets
    protected function getHeaderWidgets(): array
    {
        return [
            UsersStatsWidget::class,
            ModulesStatsWidget::class,
            SystemResourcesWidget::class,
        ];
    }

    // Override footer widgets (below the header)
    protected function getFooterWidgets(): array
    {
        return [
            SystemHealthWidget::class,
            LatestActivityWidget::class,
            AccountWidget::class,
            FilamentInfoWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Add any dashboard header actions here
        ];
    }

    // Additional content before widgets
    public function getHeader(): ?View
    {
        return view('filament.pages.dashboard-header');
    }
}
