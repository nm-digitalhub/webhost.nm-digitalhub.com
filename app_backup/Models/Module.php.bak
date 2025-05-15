<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'enabled',
        'version',
        'installed_at',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enabled' => 'boolean',
        'installed_at' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * Check if the module is installed.
     */
    public function isInstalled(): bool
    {
        return !is_null($this->installed_at);
    }

    /**
     * Enable the module.
     */
    public function enable(): void
    {
        $this->update(['enabled' => true]);
    }

    /**
     * Disable the module.
     */
    public function disable(): void
    {
        $this->update(['enabled' => false]);
    }

    /**
     * Scope a query to only include enabled modules.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    /**
     * Scope a query to only include installed modules.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInstalled($query)
    {
        return $query->whereNotNull('installed_at');
    }
}