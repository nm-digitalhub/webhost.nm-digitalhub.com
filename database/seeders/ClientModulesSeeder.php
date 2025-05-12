<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\ModuleInstaller;

class ClientModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moduleInstaller = app(ModuleInstaller::class);

        // Install core modules
        $this->command->info('Installing core client panel modules...');
        
        // Dashboard module - always the first one
        $dashboard = $moduleInstaller->installClientPanelModule(
            'דף הבית', // Dashboard in Hebrew
            'dashboard',
            'heroicon-o-home',
            'page',
            [
                'position' => 1,
                'route_name' => 'client.dashboard',
                'description' => 'Client dashboard with overview of services',
            ]
        );

        if ($dashboard['success']) {
            $this->command->info('  ✓ Dashboard module installed');
        } else {
            $this->command->error('  ✗ Failed to install Dashboard module: ' . $dashboard['message']);
        }

        // Install domains module
        $domains = $moduleInstaller->installDomainsModuleForClientPanel();
        if ($domains['success']) {
            $this->command->info('  ✓ Domains module installed');
        } else {
            $this->command->error('  ✗ Failed to install Domains module: ' . $domains['message']);
        }

        // Install billing module
        $billing = $moduleInstaller->installBillingModuleForClientPanel();
        if ($billing['success']) {
            $this->command->info('  ✓ Billing module installed');
        } else {
            $this->command->error('  ✗ Failed to install Billing module: ' . $billing['message']);
        }

        // Install support module
        $support = $moduleInstaller->installSupportModuleForClientPanel();
        if ($support['success']) {
            $this->command->info('  ✓ Support module installed');
        } else {
            $this->command->error('  ✗ Failed to install Support module: ' . $support['message']);
        }
        
        // Stats module
        $stats = $moduleInstaller->installClientPanelModule(
            'סטטיסטיקה', // Statistics in Hebrew
            'statistics',
            'heroicon-o-chart-bar',
            'page',
            [
                'position' => 50,
                'route_name' => 'client.statistics',
                'description' => 'View usage statistics and analytics',
            ]
        );

        if ($stats['success']) {
            $this->command->info('  ✓ Statistics module installed');
        } else {
            $this->command->error('  ✗ Failed to install Statistics module: ' . $stats['message']);
        }
        
        $this->command->info('Client panel modules installation completed.');
    }
}