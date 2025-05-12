<?php
return [
    'class_namespace' => 'App\\Livewire',
    'view_path' => resource_path('views/livewire'),
    'layout' => 'layouts.app',
    'asset_url' => env('ASSET_URL'),
    'app_url' => env('APP_URL'),
    'middleware_group' => 'web',
    'temporary_file_upload' => [
        'disk' => 'local',
        'rules' => ['required', 'file', 'max:5120'], // Reduced to 5MB
        'directory' => 'livewire-tmp',
        'middleware' => 'throttle:30,1', // Reduced to 30 requests per minute
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'wav', 'mp4',
            'mov', 'mp3', 'm4a',
            'jpg', 'jpeg', 'webp',
        ],
        'max_upload_time' => 10, // Increased to 10 seconds
    ],
    'manifest_path' => storage_path('app/livewire-manifest.json'),
    'legacy_model_binding' => false,
    'admin_layout' => 'livewire.admin.layout',
    'lazy_components' => true,
    'legacy_rendering' => false, // Disabled legacy rendering
    'inject_assets' => true,
    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#2299dd',
    ],
    'inject_morph_markers' => false, // Disabled unless specifically needed
    'pagination_theme' => 'tailwind',
];
