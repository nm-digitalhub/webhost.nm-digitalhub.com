<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class UsersStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected static bool $isLazy = false;
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Total users
        $totalUsers = User::count();
        
        // New users in the last 30 days
        $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();
        
        // Users by role
        $usersByRole = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('count(*) as count'))
            ->where('model_has_roles.model_type', User::class)
            ->groupBy('roles.name')
            ->get()
            ->pluck('count', 'name')
            ->toArray();
        
        // Format the roles data for display
        $rolesBreakdown = collect($usersByRole)
            ->map(fn ($count, $role) => "$role: $count")
            ->implode("\n");
            
        // Client users (assuming 'client' is a role name)
        $clientUsers = $usersByRole['client'] ?? 0;
        
        return [
            Stat::make('Total Users', $totalUsers)
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([
                    $newUsers, 
                    $totalUsers - $newUsers
                ]),
                
            Stat::make('New Users (30 Days)', $newUsers)
                ->description($newUsers > 0 ? number_format(($newUsers / $totalUsers) * 100, 1) . '% growth' : 'No growth')
                ->descriptionIcon($newUsers > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($newUsers > 0 ? 'success' : 'danger'),
                
            Stat::make('Client Users', $clientUsers)
                ->description('Users with client role')
                ->descriptionIcon('heroicon-m-user')
                ->color('warning'),
                
            Stat::make('Users by Role', count($usersByRole))
                ->description($rolesBreakdown)
                ->descriptionIcon('heroicon-m-identification')
                ->color('info'),
        ];
    }
}