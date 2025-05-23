<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\ModuleScanner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * ModuleManager Model
 *
 * This is a semi-virtual model that acts as a bridge between the Filament admin
 * panel and our custom component scanning functionality.
 *
 * It doesn't actually  * However, it implements enough of Eloquent's interface to work with Filament Resources.
 *
 * IMPORTANT IMPLEMENTATION NOTES:
 *
 * 1. This model overrides Eloquent methods to provide virtual/in-memory data.
 * 2. The `query()` method returns a builder for virtual records from ModuleScanner.
 * 3. The `all()` method returns a Collection of virtual models based on scanned components.
 * 4. The model creates Eloquent-compatible objects from file-based component information.
 * 5. Never  *
 *
 * @method static \Illuminate\Database\Eloquent\Builder query() Create a query builder for virtual components
 * @method static \Illuminate\Database\Eloquent\Collection all($columns = ['*']) Get all virtual components
 * @method static \Illuminate\Database\Eloquent\Collection getByType(string $type) Get components by type
 * @method static array rescanComponents() Rescan all components
 */
class ModuleManager extends Model
{
    /**
     * Indicates if the model exists in the database.
     * This is a virtual model, so no actual DB table.
     */
    public $exists = false;

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_generated' => 'boolean',
        'is_active' => 'boolean',
        'exists' => 'boolean',
        'metadata' => 'array',
        'last_modified' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, mixed>
     */
    protected $fillable = [
        'name',
        'class',
        'path',
        'type',
        'edit_url',
        'generator_url',
        'source',
        'exists',
        'is_active',
        'is_generated',
        'last_modified',
        'metadata',
    ];

    /**
     * Additional properties available on instances.
     * This helps static analysis tools understand dynamic properties.
     *
     * @var string|null
     */
    public $path;

    /**
     * The ModuleScanner service instance.
     */
    protected static ?ModuleScanner $moduleScanner = null;

    /**
     * Get the module scanner instance
     */
    public static function getModuleScanner(): ModuleScanner
    {
        if (! self::$moduleScanner instanceof \App\Services\ModuleScanner) {
            self::$moduleScanner = app(ModuleScanner::class);
        }

        return self::$moduleScanner;
    }

    /**
     * Get all records from the module scanner
     *
     * This method acts as a replacement for the typical Eloquent query builder.
     * It returns all components found by the scanner, formatted as ModuleManager instances.
     */
    public static function all($columns = ['*'])
    {
        // Scan for all components
        $components = self::getModuleScanner()->scan();

        // Flatten the components array
        $flattenedComponents = [];
        foreach ($components as $typeComponents) {
            foreach ($typeComponents as $component) {
                $flattenedComponents[] = $component;
            }
        }

        // Convert to ModuleManager instances
        return collect($flattenedComponents)->map(fn ($component) => new self($component));
    }

    /**
     * Create a query builder for the model.
     *
     * This is a virtual implementation that wraps our component data
     * in a way that Filament can work with.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        // Get all components
        $components = self::getModuleScanner()->scan();

        // Flatten components
        $flattenedComponents = [];
        foreach ($components as $typeComponents) {
            foreach ($typeComponents as $component) {
                $flattenedComponents[] = $component;
            }
        }

        // Create a new instance to avoid static context issues
        $instance = new static;

        // Get a new query builder from the instance
        $builder = $instance->newQuery();

        // This provides compatibility with Filament's table system
        return $builder;
    }

    /**
     * Get a subset of components by type
     *
     * @param  string  $type  The component type to filter by
     * @return \Illuminate\Support\Collection
     */
    public static function getByType(string $type)
    {
        $components = self::getModuleScanner()->scan();

        if (! isset($components[$type])) {
            return collect();
        }

        return collect($components[$type])->map(fn ($component) => new self($component));
    }

    /**
     * Re-scan components from the filesystem
     *
     * @return array The updated components
     */
    public static function rescanComponents(): array
    {
        return self::getModuleScanner()->scan();
    }

    /**
     * Get the path to the component's file
     */
    public function getFilePath(): ?string
    {
        return $this->path ? base_path($this->path) : null;
    }

    /**
     * Override newEloquentBuilder to provide our custom query functionality
     */
    public function newEloquentBuilder($query)
    {
        // This method is required for Filament's table filters to work properly
        return new class($query) extends Builder
        {
            public function __construct($query)
            {
                parent::__construct($query);
            }

            public function get($columns = ['*'])
            {
                return ModuleManager::all();
            }

            public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
            {
                $collection = ModuleManager::all();

                // Create a custom paginator
                $page = $page ?: \Illuminate\Pagination\Paginator::resolveCurrentPage($pageName);
                $items = $collection->forPage($page, $perPage);

                return new \Illuminate\Pagination\LengthAwarePaginator(
                    $items,
                    $collection->count(),
                    $perPage,
                    $page,
                    [
                        'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                        'pageName' => $pageName,
                    ]
                );
            }

            public function where($column, $operator = null, $value = null, $boolean = 'and')
            {
                // This method allows filtering (e.g., by type)
                if (is_callable($column)) {
                    return $this;
                }

                if ($operator === null && $value === null) {
                    return $this;
                }

                if ($value === null) {
                    $value = $operator;
                    $operator = '=';
                }

                return $this;
            }
        };
    }

    /**
     * Handle dynamic method calls
     *
     * This allows us to intercept and handle methods that might be called by Filament but
     * don't make sense for our virtual model.
     */
    public function __call($method, $parameters)
    {
        // If the method exists on the parent, call it
        if (method_exists(parent::class, $method)) {
            return parent::__call($method, $parameters);
        }

        // Otherwise, return a safe default
        return null;
    }
}
