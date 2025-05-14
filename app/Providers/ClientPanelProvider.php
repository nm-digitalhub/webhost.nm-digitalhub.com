<?php

namespace App\Providers;

use App\Models\ClientModule;
use App\Models\ClientPage;
use App\Services\ImpersonationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ClientPanelProvider extends ServiceProvider
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
        // Add a variable indicating impersonation status to all views
        View::composer('*', function ($view) {
            $impersonationService = app(ImpersonationService::class);
            $view->with('isImpersonating', $impersonationService->isImpersonating());
            $view->with('impersonator', $impersonationService->getImpersonator());
        });

        // Add dynamic client modules to client layout
        View::composer('layouts.client', function ($view) {
            $user = Auth::user();

            // Get all enabled client modules
            $modules = ClientModule::enabled()
                ->with('pages')
                ->ordered()
                ->get()
                ->filter(fn ($module) => $module->isVisibleToUser($user));

            // Get additional page menu items
            $menuPages = ClientPage::published()
                ->inMenu()
                ->ordered()
                ->get()
                ->filter(fn ($page) => $page->isVisibleToUser($user));

            $view->with('clientModules', $modules);
            $view->with('menuPages', $menuPages);
        });

        // Register a blade directive for checking impersonation status
        Blade::directive('impersonating', fn () => '<?php if(app(\\App\\Services\\ImpersonationService::class)->isImpersonating()): ?>');

        Blade::directive('endimpersonating', fn () => '<?php endif; ?>');

        // Register a blade directive for showing content only to users with certain roles
        Blade::directive('role', fn ($expression) => "<?php if(auth()->check() && auth()->user()->hasRole({$expression})): ?>");

        Blade::directive('endrole', fn () => '<?php endif; ?>');
    }
}
