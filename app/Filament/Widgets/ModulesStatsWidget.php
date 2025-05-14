<?php

namespace App\Filament\Widgets;

use App\Models\ClientModule;
use App\Models\Module;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ModulesStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Total modules
        $totalModules = Module::count();

        // Active modules
        $activeModules = Module::where('enabled', true)->count();

        // Inactive modules
        $inactiveModules = $totalModules - $activeModules;

        // Client modules
        $clientModules = ClientModule::count();

        // Calculate percentages for charts
        $activePercentage = $totalModules > 0 ? round(($activeModules / $totalModules) * 100) : 0;

        return [
            Stat::make('Total Modules', $totalModules)
                ->description('All system modules')
                ->descriptionIcon('heroicon-m-puzzle-piece')
                ->color('primary')
                ->chart([
                    $activeModules,
                    $inactiveModules,
                ]),

            Stat::make('Active Modules', $activeModules)
                ->description($activePercentage.'% of all modules')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Inactive Modules', $inactiveModules)
                ->description($inactiveModules > 0 ? 'Modules pending activation' : 'All modules are active')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color($inactiveModules > 0 ? 'danger' : 'success'),

            Stat::make('Client Module Instances', $clientModules)
                ->description('Modules assigned to clients')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
