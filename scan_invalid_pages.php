<?php

$resourcePath = __DIR__ . '/app/Filament/Resources';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($resourcePath));

echo "Scanning Filament Resource files for invalid getPages() definitions...\n\n";

foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getRealPath());

        // בדיקה בסיסית אם יש getPages() שמחזיר מערך עם מחלקות במקום PageRegistration
        if (preg_match('/function\s+getPages\s*\(.*\)\s*:\s*array\s*\{/', $content) &&
            preg_match('/return\s+\[\s*[\'"]\w+[\'"]\s*=>\s*Pages\\\\.*::class/', $content)
        ) {
            echo "[!] Possibly invalid getPages() in file: " . $file->getRealPath() . "\n";
        }
    }
}
