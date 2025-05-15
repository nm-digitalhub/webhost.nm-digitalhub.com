<?php

$methodsToInject = [
    'public static function isEmailVerificationRequired(\\Filament\\Panel $panel): bool
    {
        return $panel->isEmailVerificationRequired();
    }',

    'public static function isTenantSubscriptionRequired(\\Filament\\Panel $panel): bool
    {
        return $panel->isTenantSubscriptionRequired();
    }',

    'public static function getPages(): array
    {
        return [];
    }',

    'public static function getRelations(): array
    {
        return [];
    }',

    'public static function getWidgets(): array
    {
        return [];
    }',
];

$resourceFiles = glob('app/Filament/Resources/*.php');

foreach ($resourceFiles as $file) {
    $code = file_get_contents($file);
    $originalCode = $code;
    $modified = false;

    foreach ($methodsToInject as $methodCode) {
        preg_match('/function\s+(\w+)\s*\(/', $methodCode, $matches);
        $methodName = $matches[1] ?? null;

        if ($methodName && !preg_match('/function\s+' . $methodName . '\s*\(/', $code)) {
            $code = preg_replace('/}\s*$/', "\n    {$methodCode}\n}", $code);
            $modified = true;
        }
    }

    if ($modified) {
        file_put_contents($file, $code);
        echo "Updated: $file\n";
    }
}
