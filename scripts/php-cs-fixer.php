<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';  // הוספת Autoloader של Composer

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use Illuminate\Support\Facades\Log;

$rules = [
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => ['default' => 'single_space'],
    // כללים נוספים ל־PHP CS Fixer
];

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/routes',
        __DIR__ . '/resources',
        __DIR__ . '/database',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);

// התחלת הריצה של תיקון הקוד
try {
    $fixer = new \PhpCsFixer\Fixer();
    $fixer->fix();

    // הודעה בהצלחה
    Log::channel('php-cs-fixer')->info('PHP CS Fixer completed successfully.');
    Log::channel('php-cs-fixer')->info('Files fixed: ' . implode(', ', $fixer->getFixedFiles()));

} catch (\Exception $e) {
    // הודעה במקרה של שגיאה
    Log::channel('php-cs-fixer')->error('PHP CS Fixer failed: ' . $e->getMessage());
}