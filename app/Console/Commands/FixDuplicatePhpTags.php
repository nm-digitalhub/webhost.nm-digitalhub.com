<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixDuplicatePhpTags extends Command
{
    protected $signature = 'fix:duplicate-php-tags';

    protected $description = 'Fix files with duplicate PHP opening tags and class declarations';

    public function handle()
    {
        $this->info('Checking for duplicate PHP tags and class declarations...');

        $paths = [
            app_path(),
            database_path(),
            resource_path(),
        ];

        $fixedFiles = [];

        foreach ($paths as $path) {
            foreach (File::allFiles($path) as $file) {
                if ($file->getExtension() === 'php') {
                    $content = File::get($file->getPathname());
                    $wasFixed = false;

                    // Fix 1: Check for <?php tag followed by another <?php tag
                    if (preg_match('/^<\?php\s+<\?php/', $content)) {
                        $this->warn("Found duplicate PHP tags in: {$file->getPathname()}");
                        $content = preg_replace('/^<\?php\s+<\?php/', '<?php', $content);
                        $wasFixed = true;
                    }

                    // Fix 2: Check for namespace followed by another namespace (duplicate class declaration)
                    if (preg_match('/namespace\s+([^;]+);.*?class\s+(\w+).*?}\s*namespace\s+/s', (string) $content, $matches)) {
                        $this->warn("Found duplicate namespace and class declaration in: {$file->getPathname()}");

                        // Extract the first class name and namespace
                        $firstNamespace = $matches[1];
                        $className = $matches[2];

                        // Check how many class declarations we have with the same name
                        preg_match_all('/class\s+'.$className.'\s+/s', (string) $content, $classMatches);

                        if (count($classMatches[0]) > 1) {
                            // This is more complex - we need manual intervention
                            $this->error("Multiple class '{$className}' declarations found in {$file->getPathname()}");
                            $this->info('Please manually merge the class implementations');

                            // Create a backup
                            $backupPath = $file->getPathname().'.bak';
                            File::copy($file->getPathname(), $backupPath);
                            $this->info("Created backup at {$backupPath}");
                        }

                        $wasFixed = true;
                    }

                    // Fix 3: Look for files with triple or more PHP tags
                    $phpTagCount = substr_count((string) $content, '<?php');
                    if ($phpTagCount > 2) {
                        $this->error("Found {$phpTagCount} PHP tags in: {$file->getPathname()}");
                        $this->info('This requires manual intervention to fix properly.');

                        // Create a backup
                        $backupPath = $file->getPathname().'.bak';
                        File::copy($file->getPathname(), $backupPath);
                        $this->info("Created backup at {$backupPath}");

                        // Try to fix by keeping only the first tag
                        $content = preg_replace('/<\?php/', '<?php', (string) $content, 1);
                        $content = preg_replace('/<\?php/', '// <?php tag removed', (string) $content);
                        $wasFixed = true;
                    }

                    if ($wasFixed) {
                        File::put($file->getPathname(), $content);
                        $fixedFiles[] = $file->getPathname();
                        $this->info("Fixed: {$file->getPathname()}");
                    }
                }
            }
        }

        if ($fixedFiles === []) {
            $this->info('No files with duplicate PHP tags or class declarations found.');
        } else {
            $this->info(count($fixedFiles).' files fixed.');
        }

        return 0;
    }
}
