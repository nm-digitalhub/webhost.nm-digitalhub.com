<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixPhpTags extends Command
{
    protected $signature = 'fix:php-tags';
    protected $description = 'Fix files with duplicate PHP opening tags';

    public function handle()
    {
        $this->info('Checking for duplicate PHP tags...');

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

                    // Check for <?php tag followed by another <?php tag
                    if (preg_match('/^<\?php\s+<\?php/', $content)) {
                        $this->warn("Found duplicate PHP tags in: {$file->getPathname()}");

                        // Fix by removing the second tag
                        $fixedContent = preg_replace('/^<\?php\s+<\?php/', '<?php', $content);

                        File::put($file->getPathname(), $fixedContent);
                        $fixedFiles[] = $file->getPathname();

                        $this->info("Fixed: {$file->getPathname()}");
                    }
                }
            }
        }

        if ($fixedFiles === []) {
            $this->info('No files with duplicate PHP tags found.');
        } else {
            $this->info(count($fixedFiles) . ' files fixed.');
        }

        return 0;
    }
}
