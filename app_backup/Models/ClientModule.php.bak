<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientModule extends Model
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
        'icon',
        'enabled',
        'position',
        'type',
        'layout',
        'route_name',
        'component_class',
        'description',
        'metadata',
        'role_restrictions',
        'permissions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enabled' => 'boolean',
        'metadata' => 'array',
        'role_restrictions' => 'array',
        'permissions' => 'array',
    ];

    /**
     * Check if this module is visible to a specific user
     */
    public function isVisibleToUser(?User $user = null): bool
    {
        if (!$this->enabled) {
            return false;
        }

        // If no user provided or no role restrictions, check if the module is public
        if (!$user || empty($this->role_restrictions)) {
            return true;
        }

        // Check if the user has any of the required roles
        foreach ($this->role_restrictions as $role) {
            if ($user->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the pages associated with this module.
     */
    public function pages(): HasMany
    {
        return $this->hasMany(ClientPage::class, 'module_id');
    }

    /**
     * Scope query to only include enabled modules
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    /**
     * Scope query to only include modules of a specific type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope query to order by position
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position', 'asc');
    }
}