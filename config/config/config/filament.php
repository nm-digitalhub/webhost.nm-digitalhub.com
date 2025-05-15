<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Broadcasting (optional)
    |--------------------------------------------------------------------------
    | Uncomment and configure if using Laravel Echo / Pusher
    */

    'broadcasting' => [
        // 'echo' => [
        //     'broadcaster' => 'pusher',
        //     'key' => env('VITE_PUSHER_APP_KEY'),
        //     'cluster' => env('VITE_PUSHER_APP_CLUSTER'),
        //     'forceTLS' => true,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disk for File Uploads
    |--------------------------------------------------------------------------
    */

    'storage_disk' => env('FILAMENT_STORAGE_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Livewire Loading Delay
    |--------------------------------------------------------------------------
    */

    'livewire_loading_delay' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Paths and Cache
    |--------------------------------------------------------------------------
    */

    'assets_path' => 'assets/filament',
    'cache_path' => base_path('bootstrap/cache/filament'),

    /*
    |--------------------------------------------------------------------------
    | Global Appearance
    |--------------------------------------------------------------------------
    */

    'dark_mode' => true,

    'layout' => [
        'direction' => 'rtl',
        'max_content_width' => '7xl',
        'sidebar' => [
            'collapsed_by_default' => false,
        ],
    ],

    'fonts' => [
        'default' => 'Heebo, sans-serif',
    ],

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    */

    'brand' => [
        'name' => 'NM DigitalHUB',
        'logo' => 'assets/logo/nm-logo-full-color.png',
        'favicon' => 'assets/logo/nm-icon-color.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | Icon Defaults
    |--------------------------------------------------------------------------
    */

    'icons' => [
        'style' => 'heroicon-o',
        'size' => 'md',
    ],

    /*
    |--------------------------------------------------------------------------
    | Panel Configuration
    |--------------------------------------------------------------------------
    */

    'panels' => [
        'default' => [
            'path' => 'admin',
            'domain' => null,
            'tenant' => null,
            'middleware' => [
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \Filament\Http\Middleware\Authenticate::class,
                \Filament\Http\Middleware\DisableBladeIconComponents::class,
                \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
            ],
            'navigation' => [
                'collapsible' => true,
                'collapsibleOnDesktop' => false,
                'groups' => [
                    'are_collapsible' => true,
                ],
            ],
            'auth' => [
                'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
                'pages' => [
                    'login' => \Filament\Pages\Auth\Login::class,
                ],
            ],
            'pages' => [
                'dashboard' => \Filament\Pages\Dashboard::class,
            ],
            'widgets' => [
                \Filament\Widgets\AccountWidget::class,
                \Filament\Widgets\FilamentInfoWidget::class,
            ],
            'default_avatar_provider' => \Filament\AvatarProviders\UiAvatarsProvider::class,
            'sidebarWidth' => '16rem',
            'sidebarCollapsibleOnDesktop' => true,
            'unsaved_changes_alert' => true,
            'database_notifications' => [
                'enabled' => true,
                'polling_interval' => '30s',
            ],
            'dusk' => [
                'register_route' => true,
                'enabled' => env('FILAMENT_DUSK', true),
            ],
            'spa' => false,
        ],
    ],
];
