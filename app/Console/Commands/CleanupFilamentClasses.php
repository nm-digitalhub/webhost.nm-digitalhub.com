<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanupFilamentClasses extends Command
{
    protected $signature = 'filament:cleanup-classes';

    protected $description = 'Cleanup and validate Filament-related classes';

    public function handle()
    {
        $this->info('Analyzing Filament classes...');

        // Check Panel Provider
        $this->checkPanelProvider();

        // Check Filament Pages
        $this->checkFilamentPages();

        // Check Filament Resources
        $this->checkFilamentResources();

        // Check Filament Widgets
        $this->checkFilamentWidgets();

        $this->info('Filament class cleanup complete.');

        return 0;
    }

    private function checkPanelProvider()
    {
        $panelProviderPath = app_path('Providers/Filament/AdminPanelProvider.php');

        if (! File::exists($panelProviderPath)) {
            $this->warn("AdminPanelProvider not found at: {$panelProviderPath}");

            return;
        }

        $content = File::get($panelProviderPath);

        // Check for duplicate PHP tags or class declarations
        if (substr_count($content, '<?php') > 1 || substr_count($content, 'class AdminPanelProvider') > 1) {
            $this->error('Duplicate PHP tags or class declarations in AdminPanelProvider');

            // Create a fixed version
            $fixedContent = $this->fixPanelProviderContent($content);

            // Create a backup
            $backupPath = $panelProviderPath.'.bak';
            File::copy($panelProviderPath, $backupPath);
            $this->info("Created backup at {$backupPath}");

            // Save the fixed version
            File::put($panelProviderPath, $fixedContent);
            $this->info('Fixed AdminPanelProvider');
        }
    }

    private function fixPanelProviderContent($content)
    {
        // Remove duplicate PHP tags
        $content = preg_replace('/^<\?php\s+<\?php/', '<?php', (string) $content);

        // Extract namespace, imports and class content from both parts
        if (preg_match('/namespace\s+([^;]+);(.*?)class\s+AdminPanelProvider.*?{(.*?)}\s*namespace/s', (string) $content, $firstMatch) &&
            preg_match('/namespace\s+([^;]+);(.*?)class\s+AdminPanelProvider.*?{(.*?)}/s', (string) $content, $secondMatch, 0, strpos((string) $content, 'namespace', 10))) {
            // Extract imports from both parts
            preg_match_all('/use\s+([^;]+);/', $firstMatch[2], $firstImports);
            preg_match_all('/use\s+([^;]+);/', $secondMatch[2], $secondImports);

            // Combine imports (unique)
            $allImports = array_unique(array_merge($firstImports[0], $secondImports[0]));

            // Create new content with merged panel method
            $newContent = "<?php\n\nnamespace {$firstMatch[1]};\n\n";
            $newContent .= implode("\n", $allImports)."\n\n";
            $newContent .= "class AdminPanelProvider extends PanelProvider\n{\n";
            $newContent .= "    public function panel(Panel \$panel): Panel\n    {\n";
            $newContent .= "        return \$panel\n";
            $newContent .= "            ->id('admin')\n";
            $newContent .= "            ->path('admin')\n";
            $newContent .= "            ->login(Login::class)\n";
            $newContent .= "            ->direction(App::getLocale() === 'he' ? 'rtl' : 'ltr')\n";
            $newContent .= "            ->colors([\n";
            $newContent .= "                'primary' => Color::Teal,\n";
            $newContent .= "                'gray' => Color::Slate,\n";
            $newContent .= "            ])\n";
            $newContent .= "            ->darkMode(true)\n";
            $newContent .= "            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\\\Filament\\\\Resources')\n";
            $newContent .= "            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\\\Filament\\\\Pages')\n";
            $newContent .= "            ->pages([\n";
            $newContent .= "                Pages\\Dashboard::class,\n";
            $newContent .= "            ])\n";
            $newContent .= "            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\\\Filament\\\\Widgets')\n";
            $newContent .= "            ->widgets([\n";
            $newContent .= "                Widgets\\AccountWidget::class,\n";
            $newContent .= "                Widgets\\FilamentInfoWidget::class,\n";
            $newContent .= "            ])\n";
            $newContent .= "            ->navigationGroups([\n";
            $newContent .= "                NavigationGroup::make()\n";
            $newContent .= "                    ->label('ניהול מערכת')\n";
            $newContent .= "                    ->icon('heroicon-o-cog'),\n";
            $newContent .= "            ])\n";
            $newContent .= "            ->middleware([\n";
            $newContent .= "                EncryptCookies::class,\n";
            $newContent .= "                AddQueuedCookiesToResponse::class,\n";
            $newContent .= "                StartSession::class,\n";
            $newContent .= "                AuthenticateSession::class,\n";
            $newContent .= "                ShareErrorsFromSession::class,\n";
            $newContent .= "                VerifyCsrfToken::class,\n";
            $newContent .= "                SubstituteBindings::class,\n";
            $newContent .= "            ])\n";
            $newContent .= "            ->authMiddleware([\n";
            $newContent .= "                Authenticate::class,\n";
            $newContent .= "            ])\n";
            $newContent .= "            ->authGuard('web')\n";
            $newContent .= "            ->brandName('NM DigitalHUB')\n";
            $newContent .= "            ->sidebarCollapsibleOnDesktop(true);\n";
            $newContent .= "    }\n";

            return $newContent."}\n";
        }

        // If regex didn't match, just remove duplicate PHP tags and namespaces
        $content = preg_replace('/(<\?php.*?namespace\s+[^;]+;)/s', '<?php', (string) $content, 1);

        return preg_replace('/namespace\s+([^;]+);/', 'namespace App\\Providers\\Filament;', (string) $content, 1);
    }

    private function checkFilamentPages()
    {
        $pagesDir = app_path('Filament/Pages');

        if (! File::isDirectory($pagesDir)) {
            $this->warn("Filament Pages directory not found: {$pagesDir}");

            return;
        }

        $this->info("Checking Filament Pages in: {$pagesDir}");

        foreach (File::files($pagesDir) as $file) {
            if ($file->getExtension() === 'php') {
                $content = File::get($file->getPathname());

                // Check for duplicate PHP tags
                if (substr_count($content, '<?php') > 1) {
                    $this->warn("Found duplicate PHP tags in: {$file->getPathname()}");
                    $fixedContent = preg_replace('/^<\?php\s+<\?php/', '<?php', $content);
                    File::put($file->getPathname(), $fixedContent);
                    $this->info("Fixed: {$file->getPathname()}");
                }
            }
        }
    }

    private function checkFilamentResources()
    {
        $resourcesDir = app_path('Filament/Resources');

        if (! File::isDirectory($resourcesDir)) {
            $this->warn("Filament Resources directory not found: {$resourcesDir}");

            return;
        }

        $this->info("Checking Filament Resources in: {$resourcesDir}");

        foreach (File::allFiles($resourcesDir) as $file) {
            if ($file->getExtension() === 'php') {
                $content = File::get($file->getPathname());

                // Check for duplicate PHP tags
                if (substr_count($content, '<?php') > 1) {
                    $this->warn("Found duplicate PHP tags in: {$file->getPathname()}");
                    $fixedContent = preg_replace('/^<\?php\s+<\?php/', '<?php', $content);
                    File::put($file->getPathname(), $fixedContent);
                    $this->info("Fixed: {$file->getPathname()}");
                }
            }
        }
    }

    private function checkFilamentWidgets()
    {
        $widgetsDir = app_path('Filament/Widgets');

        if (! File::isDirectory($widgetsDir)) {
            $this->warn("Filament Widgets directory not found: {$widgetsDir}");

            return;
        }

        $this->info("Checking Filament Widgets in: {$widgetsDir}");

        foreach (File::files($widgetsDir) as $file) {
            if ($file->getExtension() === 'php') {
                $content = File::get($file->getPathname());

                // Check for duplicate PHP tags
                if (substr_count($content, '<?php') > 1) {
                    $this->warn("Found duplicate PHP tags in: {$file->getPathname()}");
                    $fixedContent = preg_replace('/^<\?php\s+<\?php/', '<?php', $content);
                    File::put($file->getPathname(), $fixedContent);
                    $this->info("Fixed: {$file->getPathname()}");
                }
            }
        }
    }
}
