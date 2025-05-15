<?php

$files = [
    'app/Filament/Resources/PageResource.php',
    'app/Filament/Resources/MailTemplateResource.php',
    'app/Filament/Resources/ProductResource.php',
    'app/Filament/Resources/GeneratorResource.php',
    'app/Filament/Resources/ModuleManagerResource.php',
    'app/Filament/Resources/MailSettingResource.php',
    'app/Filament/Resources/UserResource.php',
];

$widgetMethod = <<<PHP

    public static function getWidgets(): array
    {
        return [];
    }

PHP;

foreach ($files as $file) {
    $code = file_get_contents($file);

    if (strpos($code, 'function getWidgets') !== false) {
        echo "[SKIP] $file already has getWidgets()\n";
        continue;
    }

    // מצא את הסוגר האחרון של המחלקה וסמן את מיקומו
    $lastBrace = strrpos($code, '}');
    if ($lastBrace === false) {
        echo "[ERROR] No closing class brace in $file\n";
        continue;
    }

    // הוסף את המתודה לפני הסוגר האחרון
    $newCode = substr($code, 0, $lastBrace) . $widgetMethod . "\n" . substr($code, $lastBrace);

    // כתוב בחזרה
    file_put_contents($file, $newCode);
    echo "[UPDATED] Added getWidgets() to $file\n";
}
