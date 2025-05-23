<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ProjectFixer extends Command // שינוי שם המחלקה כאן
{
    // החתימה של הפקודה
    protected $signature = 'project:fix';

    // תיאור הפקודה
    protected $description = 'Comprehensive Laravel 12 + Filament 3 project fixer';

    public function handle()
    {
        $this->info('Starting comprehensive Laravel 12 + Filament 3 project fix...');

        // 1. תיקון בעיות תחביר PHP
        $this->executeCommand('fix:php-tags', 'Fixing duplicate PHP tags');

        // 2. תיקון בעיות משאבים של Filament (הכי קריטי)
        $this->executeCommand('filament:fix-page-registrations', 'Fixing Filament page registrations');

        // 3. תיקון בעיות Namespace ב-Livewire
        $this->executeCommand('livewire:fix-namespaces', 'Fixing Livewire namespaces');

        // 4. גילוי דפים שהוזזו לא נכון
        $this->executeCommand('views:detect-misplaced', 'Detecting misplaced views');

        // 5. בדיקה אם נשארו בעיות תחביר ב-PHP
        $this->executeCommand('check:php-syntax', 'Checking for PHP syntax errors');

        // 6. לוודא ש-AdminPanelProvider של Filament קיים ועובד
        $this->ensureFilamentPanelProviderExists();

        // 7. ניקוי כל המטמונים
        $this->clearAllCaches();

        $this->info('Project fix completed!');
        $this->info('Please run your project and check for any remaining issues.');

        return 0;
    }

    // ניקוי כל המטמונים
    protected function clearAllCaches()
    {
        $this->info("\nClearing all caches...");
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        $this->info('All caches cleared successfully.');
    }

    // הפעלת פקודות Artisan
    protected function executeCommand(string $command, string $description)
    {
        $this->info("\n".str_repeat('-', 50));
        $this->info($description);
        $this->info(str_repeat('-', 50));

        try {
            Artisan::call($command, [], $this->output);
        } catch (\Exception $e) {
            $this->error("Error running command '{$command}': ".$e->getMessage());
        }
    }

    // לוודא ש-AdminPanelProvider קיים
    protected function ensureFilamentPanelProviderExists()
    {
        $panelProviderPath = app_path('Providers/Filament/AdminPanelProvider.php');

        if (! File::exists($panelProviderPath)) {
            $this->line("\n".str_repeat('-', 50));
            $this->info('Creating Filament Admin Panel Provider');
            $this->info(str_repeat('-', 50));

            $directoryPath = dirname($panelProviderPath);

            if (! File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }

            $content = $this->getFilamentPanelProviderContent();
            File::put($panelProviderPath, $content);

            $this->info("Created Admin Panel Provider at: {$panelProviderPath}");
        } else {
            $this->info('Filament Admin Panel Provider already exists. Skipping creation.');

            // רישום ה-Provider בקובץ config/app.php אם הוא לא רשום כבר
            $this->registerPanelProviderInConfig();
        }
    }

    // תוכן עבור AdminPanelProvider
    protected function getFilamentPanelProviderContent()
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

    // רישום ה-Provider בקובץ config/app.php אם לא רשום כבר
    protected function registerPanelProviderInConfig()
    {
        $configPath = config_path('app.php');

        if (File::exists($configPath)) {
            $content = File::get($configPath);

            $providerClass = 'App\\Providers\\Filament\\AdminPanelProvider::class';

            if (! str_contains($content, $providerClass)) {
                $pattern = "/(\'providers\'\s*=>\s*\[\s*)/";
                $replacement = "$1\n        ".$providerClass.",\n        ";

                $content = preg_replace($pattern, $replacement, $content);
                File::put($configPath, $content);

                $this->info('Registered AdminPanelProvider in config/app.php');
            }
        }
    }
}
