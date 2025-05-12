<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// List all client modules
$modules = \App\Models\ClientModule::all();
echo "=== Client Modules ===\n";
foreach ($modules as $module) {
    echo "- {$module->name} ({$module->slug}, {$module->type})\n";
    echo "  Route: {$module->route_name}, Enabled: " . ($module->enabled ? 'Yes' : 'No') . "\n";
}

// List all client pages
$pages = \App\Models\ClientPage::all();
echo "\n=== Client Pages ===\n";
foreach ($pages as $page) {
    echo "- {$page->title} ({$page->slug})\n";
    echo "  Module ID: " . ($page->module_id ?: 'None') . ", Status: {$page->status}\n";
}

echo "\nDone.\n";