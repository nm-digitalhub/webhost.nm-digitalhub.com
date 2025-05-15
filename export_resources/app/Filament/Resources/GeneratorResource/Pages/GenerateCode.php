<?php

declare(strict_types=1);

namespace App\Filament\Resources\GeneratorResource\Pages;

use App\Filament\Resources\GeneratorResource;
use App\Models\Generator;
use App\Services\GeneratorService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\File;

class GenerateCode extends Page
{
    protected static string $resource = GeneratorResource::class;

    protected static string $view = 'filament.resources.generator-resource.pages.generate-code';

    public ?Generator $record = null;

    public string $code = '';

    public bool $showPreview = false;

    public bool $showConfirmOverwrite = false;

    public bool $isFileExists = false;

    public string $filePath = '';

    public array $generationData = [];

    public function mount($record): void
    {
        $this->record = $record;
        $this->showPreview = $this->record->preview_before_generate;
        $this->filePath = $this->getFilePath();
        $this->isFileExists = File::exists($this->filePath);
        $this->loadGenerationData();
    }

    protected function getFilePath(): string
    {
        if (! empty($this->record->target_path)) {
            return $this->record->target_path;
        }

        $basePath = app_path();
        $name = $this->record->name;

        switch ($this->record->type) {
            case 'model':
                $path = 'Models/'.$name.'.php';
                break;
            case 'resource':
                $name = str_ends_with($name, 'Resource') ? $name : $name.'Resource';
                $path = 'Filament/Resources/'.$name.'.php';
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

    protected function loadGenerationData(): void
    {
        $this->generationData = [
            'type' => $this->record->type,
            'name' => $this->record->name,
            'namespace' => $this->record->namespace ?? $this->getDefaultNamespace(),
            'extends' => $this->record->extends ?? $this->getDefaultExtends(),
            'implements' => $this->record->implements ?? [],
            'traits' => $this->record->traits ?? [],
            'fillable' => $this->record->fillable,
            'timestamps' => $this->record->timestamps,
            'soft_deletes' => $this->record->soft_deletes,
            'fields' => $this->record->fields ?? [],
            'relations' => $this->record->relations ?? [],
            'group' => $this->record->group,
            'icon' => $this->record->icon,
            'label' => $this->record->label,
        ];

        if ($this->showPreview) {
            $this->generatePreview();
        }
    }

    protected function getDefaultNamespace(): string
    {
        return match ($this->record->type) {
            'model' => 'App\\Models',
            'resource' => 'App\\Filament\\Resources',
            'page' => 'App\\Filament\\Pages',
            'widget' => 'App\\Filament\\Widgets',
            default => 'App',
        };
    }

    protected function getDefaultExtends(): string
    {
        return match ($this->record->type) {
            'model' => \Illuminate\Database\Eloquent\Model::class,
            'resource' => \Filament\Resources\Resource::class,
            'page' => \Filament\Pages\Page::class,
            'widget' => \Filament\Widgets\Widget::class,
            default => '',
        };
    }

    protected function getArtisanCommand(): string
    {
        return match ($this->record->type) {
            'model' => 'make:model',
            'resource' => 'make:filament-resource',
            'page' => 'make:filament-page',
            'widget' => 'make:filament-widget',
            default => 'make:class',
        };
    }

    protected function generatePreview(): void
    {
        // This is a simplified preview - actual generation will use Laravel's make commands
        $type = $this->record->type;
        $name = $this->record->name;
        $namespace = $this->generationData['namespace'];
        $extends = $this->generationData['extends'];

        $this->code = match ($type) {
            'model' => $this->generateModelPreview($name, $namespace, $extends),
            'resource' => $this->generateResourcePreview($name, $namespace),
            'page' => $this->generatePagePreview($name, $namespace),
            'widget' => $this->generateWidgetPreview($name, $namespace),
            default => '// No preview available for this type',
        };
    }

    protected function generateModelPreview(string $name, string $namespace, string $extends): string
    {
        $fillableFields = [];
        if (! empty($this->generationData['fields'])) {
            foreach ($this->generationData['fields'] as $field) {
                $fillableFields[] = "'{$field['name']}'";
            }
        }

        $fillableStr = $fillableFields === []
            ? '    // protected $fillable = [];'
            : "    protected \$fillable = [\n        ".implode(",\n        ", $fillableFields).",\n    ];";

        $useSoftDeletes = $this->generationData['soft_deletes']
            ? "use Illuminate\\Database\\Eloquent\\SoftDeletes;\n"
            : '';

        $softDeletesTrait = $this->generationData['soft_deletes']
            ? "    use SoftDeletes;\n"
            : '';

        $timestamps = $this->generationData['timestamps']
            ? ''
            : "    public \$timestamps = false;\n";

        // Add relations
        $relations = '';
        if (! empty($this->generationData['relations'])) {
            foreach ($this->generationData['relations'] as $relation) {
                $relationType = $relation['type'] ?? 'belongsTo';
                $relationName = $relation['name'] ?? 'relation';
                $relatedModel = $relation['related_model'] ?? 'App\\Models\\Model';
                $foreignKey = empty($relation['foreign_key']) ? '' : ", '{$relation['foreign_key']}'";
                $localKey = empty($relation['local_key']) ? '' : ", '{$relation['local_key']}'";

                $relations .= "
    public function {$relationName}()
    {
        return \$this->{$relationType}({$relatedModel}::class{$foreignKey}{$localKey});
    }
";
            }
        }

        return "<?php

namespace {$namespace};

{$useSoftDeletes}use {$extends};

class {$name} extends ".class_basename($extends)."
{
{$softDeletesTrait}{$timestamps}{$fillableStr}
{$relations}}
";
    }

    protected function generateResourcePreview(string $name, string $namespace): string
    {
        // Ensure name ends with Resource
        if (! str_ends_with($name, 'Resource')) {
            $name .= 'Resource';
        }

        $modelName = str_replace('Resource', '', $name);
        $modelClass = 'App\\Models\\'.$modelName;

        $icon = $this->generationData['icon'] ?? 'heroicon-o-rectangle-stack';
        $group = $this->generationData['group'] ? "\n    protected static ?string \$navigationGroup = '{$this->generationData['group']}';" : '';
        $label = $this->generationData['label'] ? "\n    protected static ?string \$modelLabel = '{$this->generationData['label']}';" : '';

        return "<?php

namespace {$namespace};

use {$namespace}\\{$name}\\Pages;
use {$modelClass};
use Filament\\Forms;
use Filament\\Forms\\Form;
use Filament\\Resources\\Resource;
use Filament\\Tables;
use Filament\\Tables\\Table;

class {$name} extends Resource
{
    protected static ?string \$model = {$modelName}::class;

    protected static ?string \$navigationIcon = '{$icon}';{$group}{$label}

    public static function form(Form \$form): Form
    {
        return \$form
            ->schema([
                // Add your form fields here
            ]);
    }

    public static function table(Table \$table): Table
    {
        return \$table
            ->columns([
                // Add your table columns here
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\\Actions\\EditAction::make(),
            ])
            ->bulkActions([
                Tables\\Actions\\BulkActionGroup::make([
                    Tables\\Actions\\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\\List{$modelName}s::route('/'),
            'create' => Pages\\Create{$modelName}::route('/create'),
            'edit' => Pages\\Edit{$modelName}::route('/{record}/edit'),
        ];
    }
}";
    }

    protected function generatePagePreview(string $name, string $namespace): string
    {
        $icon = $this->generationData['icon'] ?? 'heroicon-o-document-text';
        $label = $this->generationData['label'] ?? $name;
        $slug = strtolower(str_replace(' ', '-', $name));

        return "<?php

namespace {$namespace};

use Filament\\Pages\\Page;

class {$name} extends Page
{
    protected static ?string \$navigationIcon = '{$icon}';
    protected static ?string \$title = '{$label}';
    protected static string \$view = 'filament.pages.{$slug}';
}";
    }

    protected function generateWidgetPreview(string $name, string $namespace): string
    {
        $widgetType = $this->generationData['widget_type'] ?? 'stats';

        if ($widgetType === 'stats') {
            return "<?php

namespace {$namespace};

use Filament\\Widgets\\StatsOverviewWidget as BaseWidget;
use Filament\\Widgets\\StatsOverviewWidget\\Stat;

class {$name} extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', '100')
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Total Orders', '192')
                ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([2, 10, 5, 14, 6, 11, 8])
                ->color('warning'),
            Stat::make('Total Revenue', '\$3,500')
                ->description('3% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([17, 16, 14, 12, 10, 8, 6])
                ->color('danger'),
        ];
    }
}";
        } else {
            return "<?php

namespace {$namespace};

use Filament\\Widgets\\Widget;

class {$name} extends Widget
{
    protected static string \$view = 'filament.widgets.".strtolower($name)."';
".
    ($this->generationData['poll'] ? '
    protected int $pollInterval = '.($this->generationData['poll_interval'] ?? 60).';' : '').'
}';
        }
    }

    public function generate(): void
    {
        // Check if file exists and confirm overwrite is needed
        if (File::exists($this->filePath) && $this->record->confirm_overwrite && ! $this->showConfirmOverwrite) {
            $this->showConfirmOverwrite = true;

            return;
        }

        $generatorService = new GeneratorService;
        $result = $generatorService->generate($this->record, $this->showConfirmOverwrite);

        if ($result['success']) {
            // Notify success
            Notification::make()
                ->title('קוד נוצר בהצלחה')
                ->body('הקובץ נוצר בנתיב: '.$result['file_path'])
                ->success()
                ->send();

            // Set preview content to actual generated file content
            if (File::exists($result['file_path'])) {
                $this->code = File::get($result['file_path']);
                $this->isFileExists = true;
            }
        } else {
            if (isset($result['needs_confirmation']) && $result['needs_confirmation']) {
                // This is already handled above with showConfirmOverwrite
                return;
            }

            // Notify error
            Notification::make()
                ->title('שגיאה ביצירת הקוד')
                ->body($result['message'])
                ->danger()
                ->send();
        }
    }

    public function downloadCode(): void
    {
        if ($this->code === '' || $this->code === '0') {
            Notification::make()
                ->title('אין קוד להורדה')
                ->warning()
                ->send();

            return;
        }

        $fileName = basename($this->filePath);
        $tempFile = storage_path('app/public/'.$fileName);

        // Save code to a temporary file
        File::put($tempFile, $this->code);

        // Set download headers
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($tempFile));
        readfile($tempFile);

        // Clean up
        File::delete($tempFile);
    }

    public function showPreview(): void
    {
        $this->showPreview = true;
        $this->generatePreview();
    }

    public function hidePreview(): void
    {
        $this->showPreview = false;
    }

    public function confirmOverwrite(): void
    {
        $this->showConfirmOverwrite = false;

        $generatorService = new GeneratorService;
        $result = $generatorService->generate($this->record, true); // Force overwrite

        if ($result['success']) {
            // Notify success
            Notification::make()
                ->title('קוד נוצר בהצלחה')
                ->body('הקובץ נוצר בנתיב: '.$result['file_path'])
                ->success()
                ->send();

            // Set preview content to actual generated file content
            if (File::exists($result['file_path'])) {
                $this->code = File::get($result['file_path']);
                $this->isFileExists = true;
            }
        } else {
            // Notify error
            Notification::make()
                ->title('שגיאה ביצירת הקוד')
                ->body($result['message'])
                ->danger()
                ->send();
        }
    }

    public function cancelOverwrite(): void
    {
        $this->showConfirmOverwrite = false;
        Notification::make()
            ->title('יצירת קוד בוטלה')
            ->body('ניתן לבחור נתיב יעד אחר או להוריד את הקוד')
            ->warning()
            ->send();
    }
}
