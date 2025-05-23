<?php

declare(strict_types=1);

namespace App\Services;

use App\Filament\Resources\CartResource;
use App\Filament\Resources\CouponResource;
use App\Filament\Resources\PageResource;
use App\Filament\Resources\ProductResource;
use App\Models\Module;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ModuleInstaller
{
    /**
     * Install a client panel module.
     *
     * @param  string  $name  The name of the module
     * @param  string  $slug  The slug for the module
     * @param  string  $icon  The icon class or name
     * @param  string  $type  The module type (section, page, link)
     * @param  array  $config  Additional configuration
     */
    public function installClientPanelModule(string $name, string $slug, string $icon, string $type = 'page', array $config = []): array
    {
        try {
            // Check if module is already installed
            if (\App\Models\ClientModule::where('slug', $slug)->exists()) {
                return [
                    'success' => false,
                    'message' => "Client module '{$name}' is already installed.",
                ];
            }

            // Default configuration
            $defaults = [
                'enabled' => true,
                'position' => 10,
                'layout' => 'default',
                'description' => '',
                'role_restrictions' => [],
                'metadata' => [],
                'route_name' => $type === 'page' ? "client.{$slug}" : null,
                'component_class' => null,
            ];

            // Merge with provided config
            $config = array_merge($defaults, $config);

            // Create the client module
            $module = \App\Models\ClientModule::create([
                'name' => $name,
                'slug' => $slug,
                'icon' => $icon,
                'type' => $type,
                'enabled' => $config['enabled'],
                'position' => $config['position'],
                'layout' => $config['layout'],
                'description' => $config['description'],
                'role_restrictions' => $config['role_restrictions'],
                'metadata' => $config['metadata'],
                'route_name' => $config['route_name'],
                'component_class' => $config['component_class'],
            ]);

            return [
                'success' => true,
                'message' => "Client module '{$name}' installed successfully.",
                'module' => $module,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => "Failed to install client module '{$name}': ".$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Install the Support module for client panel.
     */
    public function installSupportModuleForClientPanel(): array
    {
        try {
            // First create a Support section
            $section = $this->installClientPanelModule(
                'תמיכה', // Support in Hebrew
                'support-section',
                'heroicon-o-question-mark-circle',
                'section',
                [
                    'position' => 20,
                    'description' => 'Support ticket system and knowledge base',
                ]
            );

            if (! $section['success']) {
                return $section;
            }

            // Create the Tickets module
            $tickets = $this->installClientPanelModule(
                'פניות', // Tickets in Hebrew
                'tickets',
                'heroicon-o-ticket',
                'page',
                [
                    'position' => 21,
                    'route_name' => 'client.tickets',
                    'description' => 'View and manage support tickets',
                    'metadata' => [
                        'parent_section' => 'support-section',
                        'features' => ['create_ticket', 'view_tickets', 'reply_to_tickets'],
                    ],
                ]
            );

            // Create the Knowledge Base module
            $kb = $this->installClientPanelModule(
                'מאגר מידע', // Knowledge Base in Hebrew
                'knowledge-base',
                'heroicon-o-book-open',
                'page',
                [
                    'position' => 22,
                    'route_name' => 'client.knowledge-base',
                    'description' => 'Browse knowledge base articles',
                    'metadata' => [
                        'parent_section' => 'support-section',
                        'features' => ['search_articles', 'view_articles', 'rate_articles'],
                    ],
                ]
            );

            // Create a dummy page for the knowledge base
            if ($kb['success']) {
                \App\Models\ClientPage::create([
                    'title' => 'מאגר מידע',
                    'slug' => 'knowledge-base-welcome',
                    'content' => '<h1>ברוכים הבאים למאגר המידע</h1><p>כאן תוכלו למצוא מאמרים ומדריכים שיעזרו לכם להשתמש במערכת.</p>',
                    'layout' => 'default',
                    'visibility' => 'public',
                    'status' => 'published',
                    'show_in_menu' => true,
                    'menu_position' => 1,
                    'menu_icon' => 'heroicon-o-book-open',
                    'module_id' => $kb['module']->id,
                ]);
            }

            return [
                'success' => true,
                'message' => 'Support module installed successfully for client panel.',
                'components' => [
                    'section' => $section['module'] ?? null,
                    'tickets' => $tickets['module'] ?? null,
                    'knowledge_base' => $kb['module'] ?? null,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to install Support module for client panel: '.$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Install the Billing module for client panel.
     */
    public function installBillingModuleForClientPanel(): array
    {
        try {
            // First create a Billing section
            $section = $this->installClientPanelModule(
                'חיובים', // Billing in Hebrew
                'billing-section',
                'heroicon-o-credit-card',
                'section',
                [
                    'position' => 30,
                    'description' => 'Invoices, payments, and billing information',
                ]
            );

            if (! $section['success']) {
                return $section;
            }

            // Create the Invoices module
            $invoices = $this->installClientPanelModule(
                'חשבוניות', // Invoices in Hebrew
                'invoices',
                'heroicon-o-document-text',
                'page',
                [
                    'position' => 31,
                    'route_name' => 'client.invoices',
                    'description' => 'View and pay invoices',
                    'metadata' => [
                        'parent_section' => 'billing-section',
                        'features' => ['view_invoices', 'download_invoices', 'pay_invoices'],
                    ],
                ]
            );

            // Create the Payment Methods module
            $payments = $this->installClientPanelModule(
                'אמצעי תשלום', // Payment Methods in Hebrew
                'payment-methods',
                'heroicon-o-credit-card',
                'page',
                [
                    'position' => 32,
                    'route_name' => 'client.payment-methods',
                    'description' => 'Manage payment methods',
                    'metadata' => [
                        'parent_section' => 'billing-section',
                        'features' => ['add_payment_method', 'edit_payment_method', 'delete_payment_method'],
                    ],
                ]
            );

            // Create the Subscriptions module
            $subscriptions = $this->installClientPanelModule(
                'מנויים', // Subscriptions in Hebrew
                'subscriptions',
                'heroicon-o-clock',
                'page',
                [
                    'position' => 33,
                    'route_name' => 'client.subscriptions',
                    'description' => 'Manage your subscriptions',
                    'metadata' => [
                        'parent_section' => 'billing-section',
                        'features' => ['view_subscriptions', 'cancel_subscription', 'change_plan'],
                    ],
                ]
            );

            return [
                'success' => true,
                'message' => 'Billing module installed successfully for client panel.',
                'components' => [
                    'section' => $section['module'] ?? null,
                    'invoices' => $invoices['module'] ?? null,
                    'payment_methods' => $payments['module'] ?? null,
                    'subscriptions' => $subscriptions['module'] ?? null,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to install Billing module for client panel: '.$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Install the Domains module for client panel.
     */
    public function installDomainsModuleForClientPanel(): array
    {
        try {
            // Create the Domains module
            $domains = $this->installClientPanelModule(
                'דומיינים', // Domains in Hebrew
                'domains',
                'heroicon-o-globe-alt',
                'page',
                [
                    'position' => 40,
                    'route_name' => 'client.domains',
                    'description' => 'Manage your domain names',
                    'metadata' => [
                        'features' => ['register_domain', 'transfer_domain', 'manage_dns', 'whois_privacy'],
                    ],
                ]
            );

            // Create Domain Search submodule
            $domainSearch = $this->installClientPanelModule(
                'חיפוש דומיין', // Domain Search in Hebrew
                'domain-search',
                'heroicon-o-search',
                'page',
                [
                    'position' => 41,
                    'route_name' => 'client.domain-search',
                    'description' => 'Search for available domain names',
                    'metadata' => [
                        'parent' => 'domains',
                        'features' => ['bulk_search', 'suggestions', 'premium_domains'],
                    ],
                ]
            );

            // Create DNS Management submodule
            $dnsManagement = $this->installClientPanelModule(
                'ניהול DNS', // DNS Management in Hebrew
                'dns-management',
                'heroicon-o-server',
                'page',
                [
                    'position' => 42,
                    'route_name' => 'client.dns-management',
                    'description' => 'Manage DNS records for your domains',
                    'metadata' => [
                        'parent' => 'domains',
                        'features' => ['a_records', 'cname_records', 'mx_records', 'txt_records'],
                    ],
                ]
            );

            return [
                'success' => true,
                'message' => 'Domains module installed successfully for client panel.',
                'components' => [
                    'domains' => $domains['module'] ?? null,
                    'domain_search' => $domainSearch['module'] ?? null,
                    'dns_management' => $dnsManagement['module'] ?? null,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to install Domains module for client panel: '.$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Install the Product module.
     */
    public function installProductModule(): array
    {
        try {
            // Check if module is already installed
            if ($this->isModuleInstalled('product')) {
                return [
                    'success' => false,
                    'message' => 'Product module is already installed.',
                ];
            }

            // 1. Run migrations
            if (! Schema::hasTable('products')) {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/2025_05_06_093159_create_products_table.php',
                ]);
            }

            // 2. Create Filament Resource if it doesn't exist already
            if (! class_exists(ProductResource::class)) {
                $this->createFilamentResource('Product');
            }

            // 3. Create routes if they don't exist
            $this->ensureRoutes('products');

            // 4. Create or update module record
            $module = Module::updateOrCreate(
                ['slug' => 'product'],
                [
                    'name' => 'Product Management',
                    'description' => 'Manage products, categories, and inventory.',
                    'icon' => 'heroicon-o-shopping-bag',
                    'version' => '1.0',
                    'installed_at' => now(),
                    'enabled' => true,
                    'meta' => [
                        'menu_position' => 10,
                        'requires' => [],
                        'tables' => ['products'],
                    ],
                ]
            );

            return [
                'success' => true,
                'message' => 'Product module installed successfully.',
                'module' => $module,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to install Product module: '.$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Install the Checkout module.
     */
    public function installCheckoutModule(): array
    {
        try {
            // Check if module is already installed
            if ($this->isModuleInstalled('checkout')) {
                return [
                    'success' => false,
                    'message' => 'Checkout module is already installed.',
                ];
            }

            // 1. Check for dependencies
            if (! $this->isModuleInstalled('product') || ! $this->isModuleInstalled('cart')) {
                // Install dependencies first
                if (! $this->isModuleInstalled('product')) {
                    $this->installProductModule();
                }

                if (! $this->isModuleInstalled('cart')) {
                    $this->installCartModule();
                }
            }

            // 2. Create necessary views
            $this->createCheckoutViews();

            // 3. Create routes
            $this->ensureRoutes('checkout');

            // 4. Create or update module record
            $module = Module::updateOrCreate(
                ['slug' => 'checkout'],
                [
                    'name' => 'Checkout',
                    'description' => 'Checkout process, payment integration and order processing.',
                    'icon' => 'heroicon-o-credit-card',
                    'version' => '1.0',
                    'installed_at' => now(),
                    'enabled' => true,
                    'meta' => [
                        'menu_position' => 20,
                        'requires' => ['product', 'cart'],
                        'tables' => ['orders', 'order_items', 'transactions'],
                    ],
                ]
            );

            return [
                'success' => true,
                'message' => 'Checkout module installed successfully.',
                'module' => $module,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to install Checkout module: '.$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Install the Cart module.
     */
    public function installCartModule(): array
    {
        try {
            // Check if module is already installed
            if ($this->isModuleInstalled('cart')) {
                return [
                    'success' => false,
                    'message' => 'Cart module is already installed.',
                ];
            }

            // 1. Install dependencies
            if (! $this->isModuleInstalled('product')) {
                $this->installProductModule();
            }

            // 2. Run migrations
            if (! Schema::hasTable('carts')) {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/2025_05_08_000002_create_carts_table.php',
                ]);
            }

            if (! Schema::hasTable('cart_items')) {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/2025_05_08_000003_create_cart_items_table.php',
                ]);
            }

            // 3. Create Filament Resource
            if (! class_exists(CartResource::class)) {
                $this->createFilamentResource('Cart');
            }

            // 4. Create views
            $this->createCartViews();

            // 5. Create routes
            $this->ensureRoutes('cart');

            // 6. Create or update module record
            $module = Module::updateOrCreate(
                ['slug' => 'cart'],
                [
                    'name' => 'Shopping Cart',
                    'description' => 'Shopping cart functionality with product management.',
                    'icon' => 'heroicon-o-shopping-cart',
                    'version' => '1.0',
                    'installed_at' => now(),
                    'enabled' => true,
                    'meta' => [
                        'menu_position' => 15,
                        'requires' => ['product'],
                        'tables' => ['carts', 'cart_items'],
                    ],
                ]
            );

            return [
                'success' => true,
                'message' => 'Cart module installed successfully.',
                'module' => $module,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to install Cart module: '.$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Install the Coupon module.
     */
    public function installCouponModule(): array
    {
        try {
            // Check if module is already installed
            if ($this->isModuleInstalled('coupon')) {
                return [
                    'success' => false,
                    'message' => 'Coupon module is already installed.',
                ];
            }

            // 1. Run migrations
            if (! Schema::hasTable('coupons')) {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/2025_05_08_000004_create_coupons_table.php',
                ]);
            }

            // 2. Create Filament Resource
            if (! class_exists(CouponResource::class)) {
                $this->createFilamentResource('Coupon');
            }

            // 3. Create routes
            $this->ensureRoutes('coupons');

            // 4. Create or update module record
            $module = Module::updateOrCreate(
                ['slug' => 'coupon'],
                [
                    'name' => 'Coupon Management',
                    'description' => 'Create and manage discount coupons.',
                    'icon' => 'heroicon-o-receipt-percent',
                    'version' => '1.0',
                    'installed_at' => now(),
                    'enabled' => true,
                    'meta' => [
                        'menu_position' => 25,
                        'requires' => ['cart'],
                        'tables' => ['coupons'],
                    ],
                ]
            );

            return [
                'success' => true,
                'message' => 'Coupon module installed successfully.',
                'module' => $module,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to install Coupon module: '.$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Install the Page Editor module.
     */
    public function installPageEditorModule(): array
    {
        try {
            // Check if module is already installed
            if ($this->isModuleInstalled('page')) {
                return [
                    'success' => false,
                    'message' => 'Page Editor module is already installed.',
                ];
            }

            // 1. Run migrations
            if (! Schema::hasTable('pages')) {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/2025_05_08_000005_create_pages_table.php',
                ]);
            }

            // 2. Create Filament Resource
            if (! class_exists(PageResource::class)) {
                $this->createFilamentResource('Page');
            }

            // 3. Create views
            $this->createPageViews();

            // 4. Create routes
            $this->ensureRoutes('pages');

            // 5. Create or update module record
            $module = Module::updateOrCreate(
                ['slug' => 'page'],
                [
                    'name' => 'Page Editor',
                    'description' => 'Create and manage CMS pages with rich content editing.',
                    'icon' => 'heroicon-o-document-text',
                    'version' => '1.0',
                    'installed_at' => now(),
                    'enabled' => true,
                    'meta' => [
                        'menu_position' => 30,
                        'requires' => [],
                        'tables' => ['pages'],
                    ],
                ]
            );

            return [
                'success' => true,
                'message' => 'Page Editor module installed successfully.',
                'module' => $module,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to install Page Editor module: '.$e->getMessage(),
                'exception' => $e,
            ];
        }
    }

    /**
     * Check if a module is already installed.
     */
    private function isModuleInstalled(string $slug): bool
    {
        return Module::where('slug', $slug)
            ->whereNotNull('installed_at')
            ->exists();
    }

    /**
     * Create a Filament resource for a model.
     */
    private function createFilamentResource(string $modelName): void
    {
        $resourceName = "{$modelName}Resource";
        $resourcePath = app_path("Filament/Resources/{$resourceName}.php");

        // Skip if resource already exists
        if (File::exists($resourcePath)) {
            return;
        }

        // Use Generator to create the resource
        $generator = app(GeneratorService::class);

        // Create a dummy generator model to pass to the generator service
        $generatorModel = new \App\Models\Generator([
            'name' => $resourceName,
            'type' => 'resource',
            'namespace' => 'App\\Filament\\Resources',
            'label' => $modelName,
            'icon' => $this->getIconForModel($modelName),
            'group' => 'ניהול מערכת',
            'target_path' => $resourcePath,
        ]);

        // Generate the resource
        $generator->generate($generatorModel, true);

        // Also create directory for Pages
        $pagesDir = app_path("Filament/Resources/{$resourceName}/Pages");
        if (! File::exists($pagesDir)) {
            File::makeDirectory($pagesDir, 0755, true);

            // Create basic pages (List, Create, Edit)
            $this->createResourcePage($resourceName, $modelName, 'List');
            $this->createResourcePage($resourceName, $modelName, 'Create');
            $this->createResourcePage($resourceName, $modelName, 'Edit');
        }
    }

    /**
     * Create a resource page.
     */
    private function createResourcePage(string $resourceName, string $modelName, string $pageType): void
    {
        $pageName = "{$pageType}{$modelName}s";
        if ($pageType === 'Edit' || $pageType === 'Create') {
            $pageName = "{$pageType}{$modelName}";
        }

        $pagePath = app_path("Filament/Resources/{$resourceName}/Pages/{$pageName}.php");

        // Skip if page already exists
        if (File::exists($pagePath)) {
            return;
        }

        // Create page file
        $generator = app(GeneratorService::class);

        // Create a dummy generator model for the page
        $generatorModel = new \App\Models\Generator([
            'name' => $pageName,
            'type' => 'page',
            'namespace' => "App\\Filament\\Resources\\{$resourceName}\\Pages",
            'target_path' => $pagePath,
        ]);

        // Generate the page
        $generator->generate($generatorModel, true);
    }

    /**
     * Get an appropriate icon for a model.
     */
    private function getIconForModel(string $modelName): string
    {
        $icons = [
            'Product' => 'heroicon-o-shopping-bag',
            'Cart' => 'heroicon-o-shopping-cart',
            'Coupon' => 'heroicon-o-receipt-percent',
            'Page' => 'heroicon-o-document-text',
            'Module' => 'heroicon-o-cube',
        ];

        return $icons[$modelName] ?? 'heroicon-o-rectangle-stack';
    }

    /**
     * Create cart-related views.
     */
    private function createCartViews(): void
    {
        $viewsDir = resource_path('views/cart');

        if (! File::exists($viewsDir)) {
            File::makeDirectory($viewsDir, 0755, true);

            // Create basic cart views
            $this->createView($viewsDir, 'index.blade.php', $this->getCartIndexTemplate());
            $this->createView($viewsDir, 'mini-cart.blade.php', $this->getCartMiniTemplate());
        }
    }

    /**
     * Create checkout-related views.
     */
    private function createCheckoutViews(): void
    {
        $viewsDir = resource_path('views/checkout');

        if (! File::exists($viewsDir)) {
            File::makeDirectory($viewsDir, 0755, true);

            // Create checkout views
            $this->createView($viewsDir, 'index.blade.php', $this->getCheckoutIndexTemplate());
            $this->createView($viewsDir, 'review.blade.php', $this->getCheckoutReviewTemplate());
            $this->createView($viewsDir, 'payment.blade.php', $this->getCheckoutPaymentTemplate());
            $this->createView($viewsDir, 'success.blade.php', $this->getCheckoutSuccessTemplate());
        }
    }

    /**
     * Create page-related views.
     */
    private function createPageViews(): void
    {
        $viewsDir = resource_path('views/pages');

        if (! File::exists($viewsDir)) {
            File::makeDirectory($viewsDir, 0755, true);

            // Create basic page views
            $this->createView($viewsDir, 'show.blade.php', $this->getPageShowTemplate());
        }
    }

    /**
     * Create a view file.
     */
    private function createView(string $directory, string $filename, string $content): void
    {
        $filePath = "{$directory}/{$filename}";

        if (! File::exists($filePath)) {
            File::put($filePath, $content);
        }
    }

    /**
     * Ensure routes exist.
     */
    private function ensureRoutes(string $routePrefix): void
    {
        $routesPath = base_path('routes/web.php');
        $routesContent = File::get($routesPath);

        // Only add routes if they don't already exist
        if (! Str::contains($routesContent, "Route::prefix('{$routePrefix}')")) {
            $routeStub = $this->getRouteStubForPrefix($routePrefix);

            // Append to web.php
            File::append($routesPath, "\n".$routeStub);
        }
    }

    /**
     * Get route stub for a given prefix.
     */
    private function getRouteStubForPrefix(string $routePrefix): string
    {
        return match ($routePrefix) {
            'products' => $this->getProductRoutes(),
            'cart' => $this->getCartRoutes(),
            'checkout' => $this->getCheckoutRoutes(),
            'coupons' => $this->getCouponRoutes(),
            'pages' => $this->getPageRoutes(),
            default => '',
        };
    }

    /**
     * Get product routes.
     */
    private function getProductRoutes(): string
    {
        return <<<'EOT'
// Product routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('show');
});
EOT;
    }

    /**
     * Get cart routes.
     */
    private function getCartRoutes(): string
    {
        return <<<'EOT'
// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/add', [\App\Http\Controllers\CartController::class, 'add'])->name('add');
    Route::post('/update', [\App\Http\Controllers\CartController::class, 'update'])->name('update');
    Route::post('/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('clear');
    Route::post('/apply-coupon', [\App\Http\Controllers\CartController::class, 'applyCoupon'])->name('apply-coupon');
    Route::post('/remove-coupon', [\App\Http\Controllers\CartController::class, 'removeCoupon'])->name('remove-coupon');
});
EOT;
    }

    /**
     * Get checkout routes.
     */
    private function getCheckoutRoutes(): string
    {
        return <<<'EOT'
// Checkout routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
    Route::get('/review', [\App\Http\Controllers\CheckoutController::class, 'review'])->name('review');
    Route::get('/payment', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('payment');
    Route::post('/place-order', [\App\Http\Controllers\CheckoutController::class, 'placeOrder'])->name('place-order');
    Route::get('/success/{order}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('success');
    Route::get('/cancel/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'cancel'])->name('cancel');

    // Payment gateway callback routes
    Route::get('/callback/{gateway}', [\App\Http\Controllers\CheckoutController::class, 'callback'])->name('callback');
    Route::post('/notify/{gateway}', [\App\Http\Controllers\CheckoutController::class, 'notify'])->name('notify');
});
EOT;
    }

    /**
     * Get coupon routes.
     */
    private function getCouponRoutes(): string
    {
        return <<<'EOT'
// Coupon routes (admin only)
Route::middleware(['auth', 'admin'])->prefix('admin/coupons')->name('admin.coupons.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\CouponController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Admin\CouponController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Admin\CouponController::class, 'store'])->name('store');
    Route::get('/{coupon}/edit', [\App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('edit');
    Route::put('/{coupon}', [\App\Http\Controllers\Admin\CouponController::class, 'update'])->name('update');
    Route::delete('/{coupon}', [\App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('destroy');
});
EOT;
    }

    /**
     * Get page routes.
     */
    private function getPageRoutes(): string
    {
        return <<<'EOT'
// Page routes
Route::get('/page/{page:slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');

// Admin page routes
Route::middleware(['auth', 'admin'])->prefix('admin/pages')->name('admin.pages.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Admin\PageController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Admin\PageController::class, 'store'])->name('store');
    Route::get('/{page}/edit', [\App\Http\Controllers\Admin\PageController::class, 'edit'])->name('edit');
    Route::put('/{page}', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('update');
    Route::delete('/{page}', [\App\Http\Controllers\Admin\PageController::class, 'destroy'])->name('destroy');
});
EOT;
    }

    /**
     * Get cart index template.
     */
    private function getCartIndexTemplate(): string
    {
        return <<<'EOT'
@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Shopping Cart</h1>

    @if(isset($cart) && $cart->items_count > 0)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-4 px-2">Product</th>
                            <th class="py-4 px-2">Price</th>
                            <th class="py-4 px-2">Quantity</th>
                            <th class="py-4 px-2">Total</th>
                            <th class="py-4 px-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                            <tr class="border-b">
                                <td class="py-4 px-2">
                                    <div class="flex items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover mr-4">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 mr-4 flex items-center justify-center">
                                                <span class="text-gray-500">No image</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                            @if(!empty($item->options))
                                                <div class="text-sm text-gray-600">
                                                    @foreach($item->options as $key => $value)
                                                        <span>{{ ucfirst($key) }}: {{ $value }}</span><br>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-2">{{ $item->formattedPrice }}</td>
                                <td class="py-4 px-2">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded-l">-</button>
                                        <input type="number" value="{{ $item->quantity }}" name="quantity" class="w-12 text-center border-t border-b" min="1">
                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded-r">+</button>
                                    </form>
                                </td>
                                <td class="py-4 px-2 font-semibold">{{ $item->formattedSubtotal }}</td>
                                <td class="py-4 px-2">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-wrap gap-4">
                <div class="flex-1 min-w-[320px]">
                    <h3 class="text-lg font-semibold mb-2">Apply Coupon</h3>
                    <form action="{{ route('cart.apply-coupon') }}" method="POST" class="flex">
                        @csrf
                        <input type="text" name="coupon_code" placeholder="Coupon Code" class="flex-1 px-4 py-2 border rounded-l">
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-r hover:bg-gray-700">Apply</button>
                    </form>

                    @if(session('coupon_error'))
                        <p class="text-red-500 mt-2">{{ session('coupon_error') }}</p>
                    @endif

                    @if(session('coupon_success'))
                        <p class="text-green-500 mt-2">{{ session('coupon_success') }}</p>
                    @endif
                </div>

                <div class="flex-1 min-w-[320px]">
                    <h3 class="text-lg font-semibold mb-2">Cart Totals</h3>
                    <div class="bg-gray-100 p-4 rounded">
                        <div class="flex justify-between py-2">
                            <span>Subtotal</span>
                            <span>{{ $cart->formattedTotal }}</span>
                        </div>

                        @if($cart->getAppliedCoupon())
                            <div class="flex justify-between py-2 border-t">
                                <span>Discount ({{ $cart->getAppliedCoupon()['code'] }})</span>
                                <span class="text-green-600">
                                    @if($cart->getAppliedCoupon()['type'] === 'percentage')
                                        -{{ $cart->getAppliedCoupon()['value'] }}%
                                    @else
                                        -{{ number_format($cart->getAppliedCoupon()['value'], 2) }}
                                    @endif
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between py-2 border-t">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold">{{ $cart->formattedTotal }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="mt-4 block w-full text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <p class="text-xl mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection
EOT;
    }

    /**
     * Get mini cart template.
     */
    private function getCartMiniTemplate(): string
    {
        return <<<'EOT'
<div class="bg-white rounded-lg shadow-lg p-4">
    @if(isset($cart) && $cart->items_count > 0)
        <h3 class="font-semibold mb-3">Cart ({{ $cart->items_count }})</h3>

        <div class="max-h-60 overflow-y-auto mb-3">
            @foreach($cart->items as $item)
                <div class="flex items-center py-2 border-b">
                    <div class="flex-shrink-0 mr-2">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-10 h-10 object-cover">
                        @else
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center">
                                <span class="text-xs text-gray-500">No img</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <h4 class="text-sm font-medium truncate">{{ $item->product->name }}</h4>
                        <div class="text-xs text-gray-500">{{ $item->quantity }} x {{ $item->formattedPrice }}</div>
                    </div>
                    <form action="{{ route('cart.remove') }}" method="POST" class="ml-2">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="text-red-400 hover:text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between py-2 font-semibold">
            <span>Total:</span>
            <span>{{ $cart->formattedTotal }}</span>
        </div>

        <div class="flex gap-2 mt-3">
            <a href="{{ route('cart.index') }}" class="flex-1 text-center px-3 py-2 text-xs bg-gray-200 text-gray-800 rounded hover:bg-gray-300">View Cart</a>
            <a href="{{ route('checkout.index') }}" class="flex-1 text-center px-3 py-2 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">Checkout</a>
        </div>
    @else
        <p class="text-center py-4">Your cart is empty</p>
        <a href="{{ route('products.index') }}" class="block w-full text-center px-3 py-2 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">Start Shopping</a>
    @endif
</div>
EOT;
    }

    /**
     * Get checkout index template.
     */
    private function getCheckoutIndexTemplate(): string
    {
        return <<<'EOT'
@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    @if(isset($cart) && $cart->items_count > 0)
        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-2/3 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Billing Details</h2>

                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label for="billing_name" class="block mb-1">Full Name *</label>
                                <input type="text" name="billing_name" id="billing_name" value="{{ auth()->user()->name ?? old('billing_name') }}" required class="w-full border rounded px-3 py-2">
                                @error('billing_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label for="billing_email" class="block mb-1">Email *</label>
                                <input type="email" name="billing_email" id="billing_email" value="{{ auth()->user()->email ?? old('billing_email') }}" required class="w-full border rounded px-3 py-2">
                                @error('billing_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label for="billing_phone" class="block mb-1">Phone *</label>
                                <input type="tel" name="billing_phone" id="billing_phone" value="{{ old('billing_phone') }}" required class="w-full border rounded px-3 py-2">
                                @error('billing_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label for="billing_country" class="block mb-1">Country *</label>
                                <select name="billing_country" id="billing_country" required class="w-full border rounded px-3 py-2">
                                    <option value="IL" {{ old('billing_country') == 'IL' ? 'selected' : '' }}>Israel</option>
                                    <option value="US" {{ old('billing_country') == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="GB" {{ old('billing_country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                </select>
                                @error('billing_country')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full px-2 mb-4">
                                <label for="billing_address" class="block mb-1">Address *</label>
                                <input type="text" name="billing_address" id="billing_address" value="{{ old('billing_address') }}" required class="w-full border rounded px-3 py-2">
                                @error('billing_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="billing_city" class="block mb-1">City *</label>
                                <input type="text" name="billing_city" id="billing_city" value="{{ old('billing_city') }}" required class="w-full border rounded px-3 py-2">
                                @error('billing_city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="billing_state" class="block mb-1">State</label>
                                <input type="text" name="billing_state" id="billing_state" value="{{ old('billing_state') }}" class="w-full border rounded px-3 py-2">
                                @error('billing_state')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="billing_zip" class="block mb-1">Postal Code *</label>
                                <input type="text" name="billing_zip" id="billing_zip" value="{{ old('billing_zip') }}" required class="w-full border rounded px-3 py-2">
                                @error('billing_zip')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full px-2 mb-4">
                                <label for="notes" class="block mb-1">Order Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Continue to Review</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-full lg:w-1/3 px-4">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                    <div class="border-b pb-4 mb-4">
                        @foreach($cart->items as $item)
                            <div class="flex justify-between py-2">
                                <div>
                                    <span class="font-medium">{{ $item->product->name }}</span>
                                    <span class="text-gray-600 ml-1">x {{ $item->quantity }}</span>
                                </div>
                                <span>{{ $item->formattedSubtotal }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between py-2">
                            <span>Subtotal</span>
                            <span>{{ $cart->formattedTotal }}</span>
                        </div>

                        @if($cart->getAppliedCoupon())
                            <div class="flex justify-between py-2 text-green-600">
                                <span>Discount ({{ $cart->getAppliedCoupon()['code'] }})</span>
                                <span>
                                    @if($cart->getAppliedCoupon()['type'] === 'percentage')
                                        -{{ $cart->getAppliedCoupon()['value'] }}%
                                    @else
                                        -{{ number_format($cart->getAppliedCoupon()['value'], 2) }}
                                    @endif
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between py-2 font-semibold">
                            <span>Total</span>
                            <span>{{ $cart->formattedTotal }}</span>
                        </div>
                    </div>

                    @if(!$cart->getAppliedCoupon())
                        <div class="mb-4">
                            <form action="{{ route('cart.apply-coupon') }}" method="POST" class="flex">
                                @csrf
                                <input type="text" name="coupon_code" placeholder="Coupon Code" class="flex-1 px-3 py-2 border rounded-l">
                                <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded-r hover:bg-gray-700">Apply</button>
                            </form>
                        </div>
                    @else
                        <div class="mb-4 flex justify-between items-center bg-green-50 p-2 rounded">
                            <span class="text-green-700">
                                <span class="font-medium">{{ $cart->getAppliedCoupon()['code'] }}</span> applied
                            </span>
                            <form action="{{ route('cart.remove-coupon') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-red-500 hover:text-red-700">Remove</button>
                            </form>
                        </div>
                    @endif

                    <a href="{{ route('cart.index') }}" class="block text-center text-blue-600 hover:text-blue-800">Return to Cart</a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <p class="text-xl mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection
EOT;
    }

    /**
     * Get checkout review template.
     */
    private function getCheckoutReviewTemplate(): string
    {
        return <<<'EOT'
@extends('layouts.app')

@section('title', 'Review Order')

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Review Order</h1>
            <div class="flex items-center">
                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">1</span>
                <span class="mr-2">Billing</span>
                <span class="h-px w-10 bg-gray-300 mr-2"></span>
                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">2</span>
                <span class="mr-2 font-semibold">Review</span>
                <span class="h-px w-10 bg-gray-300 mr-2"></span>
                <span class="bg-gray-300 text-gray-600 rounded-full w-6 h-6 flex items-center justify-center mr-2">3</span>
                <span>Payment</span>
            </div>
        </div>
    </div>

    @if(isset($cart) && $cart->items_count > 0)
        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-2/3 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Order Items</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="py-3 px-2">Product</th>
                                    <th class="py-3 px-2">Price</th>
                                    <th class="py-3 px-2">Quantity</th>
                                    <th class="py-3 px-2 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                    <tr class="border-b">
                                        <td class="py-3 px-2">
                                            <div class="flex items-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover mr-4">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 mr-4 flex items-center justify-center">
                                                        <span class="text-xs text-gray-500">No image</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h3 class="font-medium">{{ $item->product->name }}</h3>
                                                    @if(!empty($item->options))
                                                        <div class="text-xs text-gray-600">
                                                            @foreach($item->options as $key => $value)
                                                                <span>{{ ucfirst($key) }}: {{ $value }}</span><br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-2">{{ $item->formattedPrice }}</td>
                                        <td class="py-3 px-2">{{ $item->quantity }}</td>
                                        <td class="py-3 px-2 text-right font-medium">{{ $item->formattedSubtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Billing Details</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-medium mb-2">Contact Information</h3>
                            <p>{{ $billingDetails['billing_name'] }}</p>
                            <p>{{ $billingDetails['billing_email'] }}</p>
                            <p>{{ $billingDetails['billing_phone'] }}</p>
                        </div>

                        <div>
                            <h3 class="font-medium mb-2">Billing Address</h3>
                            <p>{{ $billingDetails['billing_address'] }}</p>
                            <p>{{ $billingDetails['billing_city'] }}, {{ $billingDetails['billing_state'] ?? '' }} {{ $billingDetails['billing_zip'] }}</p>
                            <p>{{ $countries[$billingDetails['billing_country']] ?? $billingDetails['billing_country'] }}</p>
                        </div>
                    </div>

                    @if(!empty($billingDetails['notes']))
                        <div class="mt-4">
                            <h3 class="font-medium mb-2">Order Notes</h3>
                            <p class="text-gray-700">{{ $billingDetails['notes'] }}</p>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('checkout.index') }}" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">Edit Details</a>
                        <a href="{{ route('checkout.payment') }}" class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Continue to Payment</a>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3 px-4">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                    <div class="border-b pb-4 mb-4">
                        @foreach($cart->items as $item)
                            <div class="flex justify-between py-2">
                                <div>
                                    <span class="font-medium">{{ $item->product->name }}</span>
                                    <span class="text-gray-600 ml-1">x {{ $item->quantity }}</span>
                                </div>
                                <span>{{ $item->formattedSubtotal }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between py-2">
                            <span>Subtotal</span>
                            <span>{{ $cart->formattedTotal }}</span>
                        </div>

                        @if($cart->getAppliedCoupon())
                            <div class="flex justify-between py-2 text-green-600">
                                <span>Discount ({{ $cart->getAppliedCoupon()['code'] }})</span>
                                <span>
                                    @if($cart->getAppliedCoupon()['type'] === 'percentage')
                                        -{{ $cart->getAppliedCoupon()['value'] }}%
                                    @else
                                        -{{ number_format($cart->getAppliedCoupon()['value'], 2) }}
                                    @endif
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between py-2 font-semibold text-lg">
                            <span>Total</span>
                            <span>{{ $cart->formattedTotal }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.payment') }}" class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Proceed to Payment</a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <p class="text-xl mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection
EOT;
    }

    /**
     * Get checkout payment template.
     */
    private function getCheckoutPaymentTemplate(): string
    {
        return <<<'EOT'
@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Payment</h1>
            <div class="flex items-center">
                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">1</span>
                <span class="mr-2">Billing</span>
                <span class="h-px w-10 bg-gray-300 mr-2"></span>
                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">2</span>
                <span class="mr-2">Review</span>
                <span class="h-px w-10 bg-gray-300 mr-2"></span>
                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">3</span>
                <span class="font-semibold">Payment</span>
            </div>
        </div>
    </div>

    @if(isset($cart) && $cart->items_count > 0)
        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-2/3 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Payment Method</h2>

                    <form action="{{ route('checkout.place-order') }}" method="POST" id="payment-form">
                        @csrf

                        <div class="mb-6">
                            <div class="flex flex-wrap -mx-2">
                                @foreach($paymentGateways as $gateway)
                                    <div class="w-full sm:w-1/2 md:w-1/3 px-2 mb-4">
                                        <label class="block border rounded p-4 hover:border-blue-500 cursor-pointer">
                                            <input type="radio" name="payment_gateway" value="{{ $gateway['identifier'] }}" class="mr-2" {{ $loop->first ? 'checked' : '' }}>
                                            <span>{{ $gateway['name'] }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @error('payment_gateway')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t pt-6 pb-4">
                            <label class="flex items-center mb-4">
                                <input type="checkbox" name="agree_terms" required class="mr-2">
                                <span>I agree to the <a href="{{ route('pages.show', 'terms-and-conditions') }}" class="text-blue-600 hover:underline" target="_blank">Terms and Conditions</a></span>
                            </label>

                            @error('agree_terms')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('checkout.review') }}" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">Back to Review</a>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-full lg:w-1/3 px-4">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                    <div class="border-b pb-4 mb-4">
                        @foreach($cart->items as $item)
                            <div class="flex justify-between py-2">
                                <div>
                                    <span class="font-medium">{{ $item->product->name }}</span>
                                    <span class="text-gray-600 ml-1">x {{ $item->quantity }}</span>
                                </div>
                                <span>{{ $item->formattedSubtotal }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between py-2">
                            <span>Subtotal</span>
                            <span>{{ $cart->formattedTotal }}</span>
                        </div>

                        @if($cart->getAppliedCoupon())
                            <div class="flex justify-between py-2 text-green-600">
                                <span>Discount ({{ $cart->getAppliedCoupon()['code'] }})</span>
                                <span>
                                    @if($cart->getAppliedCoupon()['type'] === 'percentage')
                                        -{{ $cart->getAppliedCoupon()['value'] }}%
                                    @else
                                        -{{ number_format($cart->getAppliedCoupon()['value'], 2) }}
                                    @endif
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between py-2 font-semibold text-lg">
                            <span>Total</span>
                            <span>{{ $cart->formattedTotal }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-100 p-4 rounded">
                        <h3 class="font-medium mb-2">Billing Details</h3>
                        <p>{{ $billingDetails['billing_name'] }}</p>
                        <p>{{ $billingDetails['billing_email'] }}</p>
                        <p>{{ $billingDetails['billing_address'] }}</p>
                        <p>{{ $billingDetails['billing_city'] }}, {{ $billingDetails['billing_state'] ?? '' }} {{ $billingDetails['billing_zip'] }}</p>
                        <p>{{ $countries[$billingDetails['billing_country']] ?? $billingDetails['billing_country'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <p class="text-xl mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection
EOT;
    }

    /**
     * Get checkout success template.
     */
    private function getCheckoutSuccessTemplate(): string
    {
        return <<<'EOT'
@extends('layouts.app')

@section('title', 'Order Complete')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6 text-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold mb-4">Order Complete!</h1>

        <p class="text-xl mb-6">Thank you for your purchase!</p>

        <div class="mb-8">
            <p class="text-gray-700">Order Number: <span class="font-semibold">{{ $order->order_number }}</span></p>
            <p class="text-gray-700">A confirmation email has been sent to <span class="font-semibold">{{ $order->billing_email }}</span></p>
        </div>

        <div class="bg-gray-100 p-6 rounded mb-8 max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

            <div class="mb-4">
                @foreach($order->items as $item)
                    <div class="flex justify-between py-2">
                        <div>
                            <span class="font-medium">{{ $item->name }}</span>
                            <span class="text-gray-600 ml-1">x {{ $item->quantity }}</span>
                        </div>
                        <span>{{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-2">
                <div class="flex justify-between py-2 font-semibold">
                    <span>Total</span>
                    <span>{{ $order->formattedTotal }}</span>
                </div>
            </div>
        </div>

        <div class="flex justify-center gap-4">
            <a href="{{ route('products.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">Continue Shopping</a>
            @auth
                <a href="{{ route('client.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded hover:bg-gray-100">View Your Orders</a>
            @endauth
        </div>
    </div>
</div>
@endsection
EOT;
    }

    /**
     * Get page show template.
     */
    private function getPageShowTemplate(): string
    {
        return <<<'EOT'
@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)

@section('meta')
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif

    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($page->featured_image)
            <div class="w-full h-64 md:h-80 bg-cover bg-center" style="background-image: url('{{ $page->getFeaturedImageUrl() }}')"></div>
        @endif

        <div class="p-6 md:p-8">
            <h1 class="text-3xl font-bold mb-6">{{ $page->title }}</h1>

            <div class="prose prose-blue max-w-none">
                {!! $page->content !!}
            </div>

            @if($page->hasChildren())
                <div class="mt-8 pt-6 border-t">
                    <h2 class="text-xl font-semibold mb-4">Related Pages</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($page->children()->published()->ordered()->get() as $childPage)
                            <a href="{{ $childPage->getUrl() }}" class="block bg-gray-100 hover:bg-gray-200 rounded p-4">
                                <h3 class="font-semibold mb-2">{{ $childPage->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $childPage->getExcerpt(100) }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
EOT;
    }
}
