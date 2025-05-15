<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ClientPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'layout',
        'visibility',
        'is_dynamic',
        'status',
        'metadata',
        'role_restrictions',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'show_in_menu',
        'menu_position',
        'menu_icon',
        'created_by',
        'updated_by',
        'module_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_dynamic' => 'boolean',
        'show_in_menu' => 'boolean',
        'metadata' => 'array',
        'role_restrictions' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (auth()->check()) {
                $page->created_by = auth()->id();
                $page->updated_by = auth()->id();
            }

            // Generate slug if not provided
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }

            // Set meta title if not provided
            if (empty($page->meta_title)) {
                $page->meta_title = $page->title;
            }
        });

        static::updating(function ($page) {
            if (auth()->check()) {
                $page->updated_by = auth()->id();
            }
        });
    }

    /**
     * Get the module that the page belongs to.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(ClientModule::class, 'module_id');
    }

    /**
     * Get the user who created the page.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the page.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Check if the page is visible to a specific user
     */
    public function isVisibleToUser(?User $user = null): bool
    {
        // Only show published pages
        if ($this->status !== 'published') {
            return false;
        }

        // Check visibility type
        if ($this->visibility === 'public') {
            return true;
        }

        // Private or role-restricted pages require a user
        if (!$user instanceof \App\Models\User) {
            return false;
        }

        // For private pages, any authenticated user can view
        if ($this->visibility === 'private') {
            return true;
        }

        // For role-restricted pages, check the user's roles
        if ($this->visibility === 'role_restricted' && !empty($this->role_restrictions)) {
            foreach ($this->role_restrictions as $role) {
                if ($user->hasRole($role)) {
                    return true;
                }
            }
            return false;
        }

        return false;
    }

    /**
     * Scope query to only include published pages
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope query to only include menu items
     */
    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    /**
     * Scope query to order by menu position
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('menu_position', 'asc');
    }
}