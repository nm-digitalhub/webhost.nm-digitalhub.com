
<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/routes',
    ])
    ->exclude([
        'vendor',
        'storage',
        'node_modules',
    ])
    ->notPath([
        'app/Filament/Resources/Pages/BadPage.php', // Replace or remove if not needed
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'single_quote' => true,
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
    ])
    ->setFinder($finder)
    ->setIndent("    ") // 4 spaces
    ->setLineEnding("\n"); // Unix-style

