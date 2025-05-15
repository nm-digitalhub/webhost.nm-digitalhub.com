<?php

$methodsToCheck = [
    'getPages' => <<<PHP

    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [];
    }

PHP,
    'getWidgets' => <<<PHP

    /**
     * @return array<class-string<\\Filament\\Widgets\\Widget>>
     */
    public static function getWidgets(): array
    {
        return [];
    }

PHP,
    'getRelations' => <<<PHP

    /**
     * @return array<class-string<\\Filament\\Resources\\RelationManagers\\RelationManager>>
     */
    public static function getRelations(): array
    {
        return [];
    }

PHP,
];

$resourceFiles = glob('app/Filament/Resources/*Resource.php');

foreach ($resourceFiles as $file) {
    echo "\nChecking file: $file\n";
    $original = file_get_contents($file);
    $modified = $original;

    $added = [];

    foreach ($methodsToCheck as $method => $template) {
        if (!str_contains($original, "function $method")) {
            echo "  - Missing method: $method()\n";
            $added[$method] = $template;
        } else {
            echo "  - Method $method() already exists.\n";
        }
    }

    if (count($added) === 0) {
        echo "  => No changes needed.\n";
        continue;
    }

    // Show preview of what will be added
    echo "\nMethods to add in $file:\n";
    foreach ($added as $method => $code) {
        echo "-------- $method() --------\n";
        echo $code;
    }

    $confirm = readline("Add missing methods to $file? [y/N]: ");
    if (strtolower(trim($confirm)) !== 'y') {
        echo "  => Skipped.\n";
        continue;
    }

    // Add before last closing brace
    $lastBrace = strrpos($modified, '}');
    if ($lastBrace !== false) {
        $insertion = "\n" . implode("\n", $added) . "\n";
        $modified = substr($modified, 0, $lastBrace) . $insertion . substr($modified, $lastBrace);
        file_put_contents($file, $modified);
        echo "  => Methods added successfully.\n";
    } else {
        echo "  => ERROR: Could not find class end in $file\n";
    }
}

echo "\nDone.\n";
