<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class LaravelProjectFixer extends Command
{
    protected $signature = 'project:fix';
    protected $description = 'Comprehensive Laravel 12 + Filament 3 project fixer';

    public function handle()
    {
        $this->info('Starting comprehensive Laravel 12 + Filament 3 project fix...');

        // 1. Fix PHP syntax issues
        $this->runCommand('fix:php-tags', 'Fixing duplicate PHP tags');

        // 2. Fix Filament resource issues (most critical)
        $this->runCommand('filament:fix-page-registrations', 'Fixing Filament page registrations');

        // 3. Fix Livewire namespace issues
        $this->runCommand('livewire:fix-namespaces', 'Fixing Livewire namespaces');

        // 4. Detect misplaced views
        $this->runCommand('views:detect-misplaced', 'Detecting misplaced views');

        // 5. Check for any remaining PHP syntax errors
        $this->runCommand('check:php-syntax', 'Checking for PHP syntax errors');

        // 6. Set up Filament Admin panel provider if missing
        $this->ensureFilamentPanelProviderExists();

        // 7. Clear all caches
        $this->clearAllCaches();

        $this->info('Project fix completed!');
        $this->info('Please run your project and check for any remaining issues.');

        return 0;
    }

    private function runCommand($command, $description)
    {
        $this->info("\n" . str_repeat('-', 50));
        $this->info($description);
        $this->info(str_repeat('-', 50));

        Artisan::call($command, [], $this->output);
    }

    private function ensureFilamentPanelProviderExists()
    {
        $panelProviderPath = app_path('Providers/Filament/AdminPanelProvider.php');

        if (!File::exists($panelProviderPath)) {
            $this->info("\n" . str_repeat('-', 50));
            $this->info('Creating Filament Admin Panel Provider');
            $this->info(str_repeat('-', 50));

            $directoryPath = dirname($panelProviderPath);

            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }

            $content = $this->getFilamentPanelProviderContent();
            File::put($panelProviderPath, $content);

            $this->info("Created Admin Panel Provider at: {$panelProviderPath}");

            // Register the provider in config/app.php if not already registered
            $this->registerPanelProviderInConfig();
        }
    }

    private function getFilamentPanelProviderContent()
    {
        return '<?php

namespace App\Providers\Filament;

use App\Filament\Pages;
use App\Filament\Resources;
use App\Filament\Widgets;
use Filament\Http\Middleware\Authenticate;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id(\'admin\')
            ->path(\'admin\')
            ->colors([
                \'primary\' => Color::Teal,
                \'gray\' => Color::Slate,
            ])
            ->darkMode(true)
            ->discoverResources(in: app_path(\'Filament/Resources\'), for: \'App\\\\Filament\\\\Resources\')
            ->discoverPages(in: app_path(\'Filament/Pages\'), for: \'App\\\\Filament\\\\Pages\')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path(\'Filament/Widgets\'), for: \'App\\\\Filament\\\\Widgets\')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}';
    }

    private function registerPanelProviderInConfig()
    {
        $configPath = config_path('app.php');

        if (File::exists($configPath)) {
            $content = File::get($configPath);

            $providerClass = 'App\\Providers\\Filament\\AdminPanelProvider::class';

            if (!str_contains($content, $providerClass)) {
                $pattern = "/(\'providers\'\s*=>\s*\[\s*)/";
                $replacement = "$1\n        " . $providerClass . ",\n        ";

                $content = preg_replace($pattern, $replacement, $content);
                File::put($configPath, $content);

                $this->info("Registered AdminPanelProvider in config/app.php");
            }
        }
    }

    private function clearAllCaches()
    {
        $this->info("\n" . str_repeat('-', 50));
        $this->info('Clearing all caches');
        $this->info(str_repeat('-', 50));

        Artisan::call('config:clear');
        $this->info('✓ Config cache cleared');

        Artisan::call('cache:clear');
        $this->info('✓ Application cache cleared');

        Artisan::call('route:clear');
        $this->info('✓ Route cache cleared');

        Artisan::call('view:clear');
        $this->info('✓ View cache cleared');

        Artisan::call('optimize:clear');
        $this->info('✓ Compiled optimization files cleared');
    }
}
