<?php

$directory = __DIR__ . '/app/Filament/Resources';
$backupDir = __DIR__ . '/fix_backups_' . date('Ymd_His');

if (!is_dir($backupDir)) {
    mkdir($backupDir);
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($directory)
);

foreach ($files as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') continue;

    $path = $file->getRealPath();
    $content = file_get_contents($path);

    // Match 'Pages\Xxx::route(...)' only in getPages arrays
    $pattern = '/Pages\\\\([A-Za-z0-9_]+)::route\((.*?)\)/';

    if (preg_match_all($pattern, $content, $matches)) {
        $fixedContent = preg_replace($pattern, 'Pages\\\\$1::class', $content);

        if ($fixedContent !== $content) {
            // Backup original
            $backupPath = $backupDir . '/' . basename($path);
            copy($path, $backupPath);

            // Write new content
            file_put_contents($path, $fixedContent);

            echo "✔ Updated: {$path}\n";
        }
    }
}

echo "\n✅ All done. Backup saved to: {$backupDir}\n";
