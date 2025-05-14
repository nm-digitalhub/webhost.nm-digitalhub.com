<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * ComponentMetadata Model
 *
 * Value object model to store and manipulate component metadata.
 * This model is not database-backed but provides structured access to component information.
 */
class ComponentMetadata
{
    /**
     * The full class name
     */
    public string $class;

    /**
     * The short class name (without namespace)
     */
    public string $name;

    /**
     * The file path relative to the application root
     */
    public string $path;

    /**
     * The component type (resource, page, widget, livewire)
     */
    public string $type;

    /**
     * URL for editing/viewing the component
     */
    public string $editUrl;

    /**
     * URL for editing the generator that created this component (if applicable)
     */
    public string $generatorUrl;

    /**
     * Source of the component (manual or generator)
     */
    public string $source;

    /**
     * Whether the class physically exists and can be loaded
     */
    public bool $exists;

    /**
     * Whether the component is active and properly registered
     */
    public bool $isActive;

    /**
     * Whether the component was created by a generator
     */
    public bool $isGenerated;

    /**
     * Last modification timestamp
     */
    public string $lastModified;

    /**
     * Additional component-specific metadata
     */
    public array $metadata;

    /**
     * Create a new ComponentMetadata instance
     *
     * @param  array  $data  Component data
     */
    public function __construct(array $data)
    {
        $this->class = $data['class'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->path = $data['path'] ?? '';
        $this->type = $data['type'] ?? '';
        $this->editUrl = $data['edit_url'] ?? '#';
        $this->generatorUrl = $data['generator_url'] ?? '#';
        $this->source = $data['source'] ?? 'ידני';
        $this->exists = $data['exists'] ?? false;
        $this->isActive = $data['is_active'] ?? false;
        $this->isGenerated = $data['is_generated'] ?? false;
        $this->lastModified = $data['last_modified'] ?? now()->format('Y-m-d H:i:s');
        $this->metadata = $data['metadata'] ?? [];
    }

    /**
     * Convert component metadata to an array
     */
    public function toArray(): array
    {
        return [
            'class' => $this->class,
            'name' => $this->name,
            'path' => $this->path,
            'type' => $this->type,
            'edit_url' => $this->editUrl,
            'generator_url' => $this->generatorUrl,
            'source' => $this->source,
            'exists' => $this->exists,
            'is_active' => $this->isActive,
            'is_generated' => $this->isGenerated,
            'last_modified' => $this->lastModified,
            'metadata' => $this->metadata,
        ];
    }

    /**
     * Create a ComponentMetadata from array data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    /**
     * Create a ComponentMetadata collection from an array of component data
     */
    public static function collectionFromArray(array $componentsData): \Illuminate\Support\Collection
    {
        return collect($componentsData)->map(fn ($data) => self::fromArray($data));
    }

    /**
     * Get a formatted representation of the last modified date
     *
     * @param  string  $format  Date format
     */
    public function formattedLastModified(string $format = 'd/m/Y H:i'): string
    {
        return Carbon::parse($this->lastModified)->format($format);
    }

    /**
     * Get a human-readable time difference from now
     */
    public function lastModifiedDiffForHumans(): string
    {
        return Carbon::parse($this->lastModified)->diffForHumans();
    }

    /**
     * Get a specific metadata value
     *
     * @param  string  $key  The key to retrieve
     * @param  mixed  $default  Default value if key doesn't exist
     * @return mixed
     */
    public function getMetadata(string $key, $default = null)
    {
        return $this->metadata[$key] ?? $default;
    }

    /**
     * Check if the component has a specific capability based on metadata
     *
     * @param  string  $capability  The capability to check
     */
    public function hasCapability(string $capability): bool
    {
        return $this->getMetadata("has_{$capability}", false);
    }

    /**
     * Get a readable type label
     */
    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'resources' => 'Resource',
            'pages' => 'Page',
            'widgets' => 'Widget',
            'livewire' => 'Livewire',
            default => ucfirst($this->type)
        };
    }

    /**
     * Get the component's display name
     */
    public function getDisplayName(): string
    {
        if ($this->type === 'resources') {
            return $this->getMetadata('model_label') ?? class_basename($this->name);
        }

        if ($this->type === 'pages') {
            return $this->getMetadata('title') ?? class_basename($this->name);
        }

        return class_basename($this->name);
    }

    /**
     * Determine if the component is properly structured
     */
    public function isProperlyStructured(): bool
    {
        if (! $this->exists) {
            return false;
        }

        return match ($this->type) {
            'resources' => $this->hasCapability('form') &&
                   $this->hasCapability('table') &&
                   $this->hasCapability('pages'),
            'pages' => $this->hasCapability('render') &&
                   $this->getMetadata('view') !== null,
            'widgets' => true,
            'livewire' => $this->hasCapability('render'),
            default => false,
        };
    }

    /**
     * Get status text for the component
     */
    public function getStatusText(): string
    {
        if (! $this->exists) {
            return 'לא קיים';
        }

        if (! $this->isActive) {
            return 'לא פעיל';
        }

        if (! $this->isProperlyStructured()) {
            return 'דורש תיקון';
        }

        return 'תקין';
    }
}
