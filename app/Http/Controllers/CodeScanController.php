<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CodeScanController extends Controller
{
    public function scan(Request $request)
    {
        base_path();

        // קבצי קונפיג
        $configPath = config_path();
        $configFiles = File::exists($configPath) ? File::allFiles($configPath) : [];
        $config = collect($configFiles)->map(fn ($file) => $file->getRelativePathname());

        // קבצי מסלולים
        $routePath = base_path('routes');
        $routeFiles = File::exists($routePath) ? File::allFiles($routePath) : [];
        $routes = collect($routeFiles)->map(fn ($file) => $file->getRelativePathname());

        // קבצי מודלים
        $modelsPath = app_path('Models');
        $models = File::exists($modelsPath) ? File::allFiles($modelsPath) : [];
        $hasApiTokens = false;
        foreach ($models as $modelFile) {
            if (str_contains(file_get_contents($modelFile), 'HasApiTokens')) {
                $hasApiTokens = true;
                break;
            }
        }

        // בדיקה אם טבלת personal_access_tokens קיימת
        $hasTokensTable = Schema::hasTable('personal_access_tokens');

        // קבצי בקרות
        $controllersPath = app_path('Http/Controllers');
        $controllers = File::exists($controllersPath) ? File::allFiles($controllersPath) : [];

        // קבצי Blade (login וכו')
        $bladePath = resource_path('views/auth');
        $bladeFiles = File::exists($bladePath) ? File::allFiles($bladePath) : [];

        return response()->json([
            'config_files' => $config->values(),
            'routes' => $routes->values(),
            'has_api_tokens_trait' => $hasApiTokens,
            'has_personal_access_tokens_table' => $hasTokensTable,
            'controller_files' => collect($controllers)->map->getRelativePathname(),
            'auth_blade_files' => collect($bladeFiles)->map->getRelativePathname(),
            'note' => 'סקריפט מותאם לפרויקטים ללא Kernel.php',
        ]);
    }
}
