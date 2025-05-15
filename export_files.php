<?php

// הגדרת תיקיות ומסלולי קבצים לבדיקת סריקה
$directoriesToScan = [
    '/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com/app/Filament',
    '/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com/app/Actions',
    '/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com/app/Console',
    '/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com/app/Http',
    '/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com/app/Livewire',
    '/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com/routes/web.php',
];

// סרוק את כל הקבצים בתיקיות שצוינו
function scanDirectory($directory)
{
    $files = [];
    if (is_dir($directory)) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        $files = iterator_to_array($files);
    }

    return $files;
}

// אוסף קבצים להצגה או לייצוא
function collectFiles($directories)
{
    $collectedFiles = [];
    foreach ($directories as $directory) {
        $collectedFiles[$directory] = scanDirectory($directory);
    }

    return $collectedFiles;
}

// ייצוא קובץ ב־JSON עם מידע על הקבצים
function exportFile($data, $outputFile = 'exported_code.json')
{
    file_put_contents($outputFile, json_encode($data, JSON_PRETTY_PRINT));
    echo "Export complete: $outputFile\n";
}

// קריאה לפונקציות
$collectedFiles = collectFiles($directoriesToScan);

// ייצוא המידע לפורמט JSON
exportFile($collectedFiles);
