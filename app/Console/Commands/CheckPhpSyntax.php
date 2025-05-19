<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class CheckPhpSyntax extends Command
{
    protected $signature = 'check:php-syntax';

    protected $description = 'Check PHP syntax in all project files';

    public function handle()
    {
        $this->info('Checking PHP syntax in project files...');

        $paths = [
            app_path(),
            database_path(),
            resource_path(),
        ];

        $errors = [];

        foreach ($paths as $path) {
            $this->info("Checking files in: {$path}");

            $process = new Process([
                'find',
                $path,
                '-type', 'f',
                '-name', '*.php',
                '-exec', 'php', '-l', '{}', ';',
            ]);

            $process->run();

            $output = $process->getOutput();
            $lines = explode("\n", $output);

            foreach ($lines as $line) {
                if (str_contains($line, 'Parse error') || str_contains($line, 'syntax error')) {
                    $errors[] = $line;
                    $this->error($line);
                }
            }
        }

        if ($errors === []) {
            $this->info('No PHP syntax errors found!');

            return 0;
        } else {
            $this->error(count($errors).' syntax errors found.');

            return 1;
        }
    }
}
