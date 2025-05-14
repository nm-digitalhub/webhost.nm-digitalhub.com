<?php

namespace App\Services;

use App\Models\GenerationLog;
use App\Models\Generator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeneratorService
{
    /**
     * Generate code based on the generator configuration
     */
    public function generate(Generator $generator, bool $overwrite = false): array
    {
        try {
            $filePath = $this->getFilePath($generator);

            // Check if file exists and we're not overwriting
            if (File::exists($filePath) && ! $overwrite) {
                return [
                    'success' => false,
                    'needs_confirmation' => true,
                    'file_path' => $filePath,
                    'message' => 'File already exists. Confirm overwrite.',
                ];
            }

            // Create directory if needed
            $directory = dirname($filePath);
            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Run Artisan command based on type
            $command = $this->getArtisanCommand($generator);
            $args = $this->getCommandArguments($generator);

            Artisan::call($command, $args);
            $output = Artisan::output();

            // For pages and widgets, we may need to create a view file
            if (in_array($generator->type, ['page', 'widget'])) {
                $this->createViewFile($generator);
            }

            // Log the generation
            $this->logGeneration($generator, $command, $args, 'success', $filePath, $overwrite);

            return [
                'success' => true,
                'file_path' => $filePath,
                'output' => $output,
                'message' => 'Code generated successfully.',
            ];
        } catch (\Exception $e) {
            Log::error('Code generation failed: '.$e->getMessage(), [
                'generator' => $generator->toArray(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Log the generation error
            $this->logGeneration(
                $generator,
                $this->getArtisanCommand($generator),
                $this->getCommandArguments($generator),
                'error',
                $this->getFilePath($generator),
                false,
                $e->getMessage()
            );

            return [
                'success' => false,
                'message' => 'Error generating code: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Get the correct file path for the generated code
     */
    public function getFilePath(Generator $generator): string
    {
        if (! empty($generator->target_path)) {
            return $generator->target_path;
        }

        $basePath = app_path();
        $name = $generator->name;

        switch ($generator->type) {
            case 'model':
                $path = 'Models/'.$name.'.php';
                break;
            case 'resource':
                $resourceName = str_ends_with($name, 'Resource') ? $name : $name.'Resource';
                $path = 'Filament/Resources/'.$resourceName.'.php';
                break;
            case 'page':
                $path = 'Filament/Pages/'.$name.'.php';
                break;
            case 'widget':
                $path = 'Filament/Widgets/'.$name.'.php';
                break;
            default:
                $path = $name.'.php';
        }

        return $basePath.'/'.$path;
    }

    /**
     * Get the appropriate Artisan command for code generation
     */
    protected function getArtisanCommand(Generator $generator): string
    {
        return match ($generator->type) {
            'model' => 'make:model',
            'resource' => 'make:filament-resource',
            'page' => 'make:filament-page',
            'widget' => 'make:filament-widget',
            default => 'make:class',
        };
    }

    /**
     * Get command arguments based on generator configuration
     */
    protected function getCommandArguments(Generator $generator): array
    {
        $args = ['name' => $generator->name];

        switch ($generator->type) {
            case 'model':
                if ($generator->soft_deletes) {
                    $args['--soft-deletes'] = true;
                }
                if ($generator->timestamps !== null && ! $generator->timestamps) {
                    $args['--no-timestamps'] = true;
                }
                break;

            case 'resource':
                $args['--generate'] = true; // Generate related pages
                if (! empty($generator->label)) {
                    $args['--label'] = $generator->label;
                }
                break;

            case 'page':
                // No specific page options
                break;

            case 'widget':
                $widgetType = $generator->widget_type ?? '';

                switch ($widgetType) {
                    case 'stats':
                        $args['--stats-overview'] = true;
                        break;
                    case 'chart':
                        $args['--chart'] = true;
                        break;
                    case 'table':
                        $args['--table'] = true;
                        break;
                    default:
                        // Default widget
                }

                if (property_exists($generator, 'poll') && $generator->poll !== null && $generator->poll) {
                    $args['--poll'] = $generator->poll_interval ?? 60;
                }
                break;
        }

        return $args;
    }

    /**
     * Create a view file for pages and widgets
     */
    protected function createViewFile(Generator $generator): void
    {
        $name = Str::kebab($generator->name);

        if ($generator->type === 'page') {
            $viewName = 'filament.pages.'.$name;
            Artisan::call('make:view', [
                'name' => $viewName,
                '--type' => 'blade',
            ]);
        } elseif ($generator->type === 'widget') {
            $viewName = 'filament.widgets.'.$name;
            Artisan::call('make:view', [
                'name' => $viewName,
                '--type' => 'blade',
            ]);
        }
    }

    /**
     * Log the generation process
     */
    protected function logGeneration(
        Generator $generator,
        string $command,
        array $args,
        string $status,
        string $filePath,
        bool $overwritten,
        ?string $errorMessage = null
    ): void {
        $log = new GenerationLog([
            'user_id' => Auth::id(),
            'generator_id' => $generator->id,
            'entity_type' => $generator->type,
            'entity_name' => $generator->name,
            'namespace' => $generator->namespace ?? $this->getDefaultNamespace($generator),
            'command' => $command,
            'params' => $args,
            'status' => $status,
            'error_message' => $errorMessage,
            'file_path' => $filePath,
            'overwritten' => $overwritten,
        ]);

        $log->save();
    }

    /**
     * Get default namespace based on entity type
     */
    protected function getDefaultNamespace(Generator $generator): string
    {
        return match ($generator->type) {
            'model' => 'App\\Models',
            'resource' => 'App\\Filament\\Resources',
            'page' => 'App\\Filament\\Pages',
            'widget' => 'App\\Filament\\Widgets',
            default => 'App',
        };
    }
}
