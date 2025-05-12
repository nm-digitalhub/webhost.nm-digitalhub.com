<?php

namespace App\Filament\Resources\ModuleManagerResource\Pages;

use App\Filament\Resources\ModuleManagerResource;
use App\Models\ModuleManager;
use App\Services\ModuleScanner;
use App\Models\ComponentMetadata;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

/**
 * ListModuleManagers Page
 * 
 * Displays all modules in the application with both a Table view and a Category view.
 * Provides filtering, sorting, and management capabilities for Resources, Pages, Widgets, 
 * and Livewire components.
 */
class ListModuleManagers extends ListRecords
{
    protected static string $resource = ModuleManagerResource::class;
    
    /**
     * The view mode (table or category)
     */
    #[Url]
    public string $viewMode = 'category';
    
    /**
     * Current active tab for category view
     */
    #[Url]
    public ?string $activeTab = 'resources';
    
    /**
     * Filter applied to components
     */
    #[Url]
    public array $componentFilters = [
        'type' => null,
        'source' => null,
        'exists' => null,
    ];
    
    /**
     * Sort options for components
     */
    #[Url]
    public array $componentSort = [
        'column' => 'last_modified',
        'direction' => 'desc',
    ];
    
    /**
     * Scanned components
     */
    public array $components = [];
    
    /**
     * Initialize the page and perform initial scan
     */
    public function mount(): void
    {
        parent::mount();
        
        // Perform initial component scan
        $this->scanComponents();
    }
    
    /**
     * Scan for all components using the ModuleScanner service
     */
    public function scanComponents(): void
    {
        $scanner = app(ModuleScanner::class);
        $this->components = $scanner->scan();
    }
    
    /**
     * Get header actions for the page
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('toggle_view')
                ->label(fn () => $this->viewMode === 'table' 
                    ? 'תצוגת קטגוריות' 
                    : 'תצוגת טבלה')
                ->icon(fn () => $this->viewMode === 'table' 
                    ? 'heroicon-o-view-columns' 
                    : 'heroicon-o-table-cells')
                ->action(function () {
                    $this->viewMode = $this->viewMode === 'table' ? 'category' : 'table';
                }),
                
            Actions\Action::make('scan')
                ->label('סרוק מחדש')
                ->icon('heroicon-o-magnifying-glass')
                ->action(function () {
                    // Reset components array
                    $this->components = [
                        'resources' => [],
                        'pages' => [],
                        'widgets' => [],
                        'livewire' => []
                    ];
                    
                    // Perform scan
                    $this->scanComponents();
                    
                    // Show notification
                    Notification::make()
                        ->title('סריקת מודולים הושלמה בהצלחה')
                        ->success()
                        ->send();
                }),
                
            Actions\Action::make('create_component')
                ->label('צור רכיב חדש')
                ->icon('heroicon-o-plus')
                ->url(route('filament.admin.resources.generators.create'))
                ->openUrlInNewTab(),
        ];
    }
    
    /**
     * Get count of components by type for tab badges
     */
    #[Computed]
    public function getComponentCount(): array
    {
        return [
            'resources' => count($this->components['resources'] ?? []),
            'pages' => count($this->components['pages'] ?? []),
            'widgets' => count($this->components['widgets'] ?? []),
            'livewire' => count($this->components['livewire'] ?? []),
            'total' => count($this->getAllComponents()),
        ];
    }
    
    /**
     * Get all components flattened into a single array
     */
    #[Computed]
    public function getAllComponents(): array
    {
        $allComponents = [];
        
        foreach ($this->components as $components) {
            foreach ($components as $component) {
                $allComponents[] = $component;
            }
        }
        
        return $allComponents;
    }
    
    /**
     * Get components for the current active tab
     */
    #[Computed]
    public function getActiveTabComponents(): array
    {
        return $this->components[$this->activeTab] ?? [];
    }
    
    /**
     * Apply filters to components
     */
    #[Computed]
    public function getFilteredComponents(): array
    {
        $components = $this->getAllComponents();
        
        // Apply type filter
        if (!empty($this->componentFilters['type'])) {
            $components = array_filter($components, fn($component) => $component['type'] === $this->componentFilters['type']);
        }
        
        // Apply source filter
        if (!empty($this->componentFilters['source'])) {
            $components = array_filter($components, function ($component) {
                if ($this->componentFilters['source'] === 'generated') {
                    return $component['is_generated'] === true;
                }
                return $component['is_generated'] === false;
            });
        }
        
        // Apply exists filter
        if ($this->componentFilters['exists'] !== null) {
            $components = array_filter($components, fn($component) => $component['exists'] === (bool)$this->componentFilters['exists']);
        }
        
        return array_values($components);
    }
    
    /**
     * Sort filtered components
     */
    #[Computed]
    public function getSortedFilteredComponents(): array
    {
        $components = $this->getFilteredComponents();
        
        // Apply sorting
        usort($components, function ($a, $b) {
            $column = $this->componentSort['column'];
            $direction = $this->componentSort['direction'];
            
            if ($direction === 'asc') {
                return $a[$column] <=> $b[$column];
            } else {
                return $b[$column] <=> $a[$column];
            }
        });
        
        return $components;
    }
    
    /**
     * Set active tab
     */
    public function setActiveTab(string $tab): void
    {
        if (isset($this->components[$tab])) {
            $this->activeTab = $tab;
        }
    }
    
    /**
     * Set filter value
     */
    public function setFilter(string $filterKey, $value): void
    {
        $this->componentFilters[$filterKey] = $value;
    }
    
    /**
     * Set sort options
     */
    public function setSort(string $column, string $direction = 'asc'): void
    {
        $this->componentSort = [
            'column' => $column,
            'direction' => $direction,
        ];
    }
    
    /**
     * Toggle sort direction for a column
     */
    public function toggleSort(string $column): void
    {
        if ($this->componentSort['column'] === $column) {
            // Toggle direction
            $this->componentSort['direction'] = 
                $this->componentSort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            // New column, default to asc
            $this->componentSort = [
                'column' => $column,
                'direction' => 'asc',
            ];
        }
    }
    
    /**
     * Clear all filters
     */
    public function clearFilters(): void
    {
        $this->componentFilters = [
            'type' => null,
            'source' => null,
            'exists' => null,
        ];
    }
    
    /**
     * Required method to comply with ListRecords contract
     * Returns table data in a format Filament can understand
     */
    public function getTableRecords(): EloquentCollection|Paginator
    {
        // We're overriding the default table with our custom view,
        // so we return an empty collection here
        return new EloquentCollection([]);
    }
    
    /**
     * Render the page with the appropriate view
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        // Always use our custom view
        return view('filament.resources.module-manager.pages.list-module-managers', [
            'components' => $this->components,
            'componentCount' => $this->getComponentCount(),
            'activeTabComponents' => $this->getActiveTabComponents(),
            'filteredComponents' => $this->getFilteredComponents(),
            'sortedFilteredComponents' => $this->getSortedFilteredComponents(),
        ]);
    }
}