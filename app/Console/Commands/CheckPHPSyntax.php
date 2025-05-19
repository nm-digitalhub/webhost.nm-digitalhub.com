<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class CheckPHPSyntax extends Command
{
    protected $signature = 'check:php-syntax
                           {--fix : Attempt to fix syntax issues automatically}';

    protected $description = 'Check PHP syntax in all project files';

    protected $errorFiles = [];

    public function handle()
    {
        $this->info('Checking PHP syntax in project files...');

        // Check application directories
        $this->checkDirectory(app_path());
        $this->checkDirectory(base_path('routes'));
        $this->checkDirectory(base_path('config'));

        // Report results
        if (count($this->errorFiles) > 0) {
            $this->error('Found '.count($this->errorFiles).' files with syntax errors:');

            foreach ($this->errorFiles as $file => $error) {
                $this->warn(" - {$file}");
                $this->line("   Error: {$error}");

                // Fix if option is set
                if ($this->option('fix')) {
                    $this->fixSyntaxIssue($file, $error);
                }
            }

            if (! $this->option('fix')) {
                $this->info('Run with --fix option to attempt automatic fixes');
            }

            return 1;
        } else {
            $this->info('All PHP files have valid syntax!');

            return 0;
        }
    }

    private function checkDirectory($directory)
    {
        if (! File::isDirectory($directory)) {
            return;
        }

        $files = File::glob("{$directory}/*.php");
        foreach ($files as $file) {
            $this->checkFile($file);
        }

        // Check subdirectories
        $directories = File::directories($directory);
        foreach ($directories as $subdir) {
            $this->checkDirectory($subdir);
        }
    }

    private function checkFile($file)
    {
        // Skip vendor directory
        if (Str::contains($file, '/vendor/')) {
            return;
        }

        $process = new Process(['php', '-l', $file]);
        $process->run();

        if (! $process->isSuccessful()) {
            $error = trim($process->getErrorOutput());
            // Extract just the error message, not the full output
            if (preg_match('/Parse error:\s*(.*?)\s*in/', $error, $matches)) {
                $error = $matches[1];
            }

            $this->errorFiles[$file] = $error;
        }
    }

    private function fixSyntaxIssue($file, $error)
    {
        $content = File::get($file);
        $fixed = false;

        // Common syntax issues and fixes
        if (Str::contains($error, 'unexpected end of file')) {
            // Fix missing closing braces
            $openBraces = substr_count($content, '{');
            $closeBraces = substr_count($content, '}');

            if ($openBraces > $closeBraces) {
                $content .= str_repeat("\n}", $openBraces - $closeBraces);
                $fixed = true;
                $this->info("Fixed missing closing braces in {$file}");
            }
        } elseif (Str::contains($error, 'unexpected') && Str::contains($error, 'expecting')) {
            // Fix missing semicolons (common issue)
            // Try to find the line with the error
            if (Str::contains($error, 'expecting ";"') && preg_match('/on line (\d+)/', (string) $error, $matches)) {
                $lineNumber = (int) $matches[1];
                $lines = explode("\n", $content);
                if (isset($lines[$lineNumber - 1])) {
                    $line = $lines[$lineNumber - 1];
                    if (! Str::endsWith(trim($line), ';') && ! Str::endsWith(trim($line), '{') && ! Str::endsWith(trim($line), '}')) {
                        $lines[$lineNumber - 1] = rtrim($line).';';
                        $content = implode("\n", $lines);
                        $fixed = true;
                        $this->info("Fixed missing semicolon on line {$lineNumber} in {$file}");
                    }
                }
            }
        }

        // Save fixed content if we made a fix
        if ($fixed) {
            // Make a backup
            File::put($file.'.syntax-error.bak', File::get($file));

            // Save the fixed version
            File::put($file, $content);

            // Check if the fix worked
            $process = new Process(['php', '-l', $file]);
            $process->run();

            if ($process->isSuccessful()) {
                $this->info("Successfully fixed syntax in {$file}");
                unset($this->errorFiles[$file]);
            } else {
                $this->error("Attempted fix did not resolve syntax issues in {$file}");
            }
        } else {
            $this->warn("Could not automatically fix syntax in {$file}");
        }
    }
}
