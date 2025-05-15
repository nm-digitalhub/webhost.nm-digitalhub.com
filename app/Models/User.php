<?php

declare(strict_types=1);

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Determine if the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['admin', 'super-admin']) || $this->hasPermissionTo('access_admin_panel');
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        // Use HasRoles trait methods for role checking
        return $this->hasRole('admin');
    }

    /**
     * Relation: A user can have many generation logs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function generationLogs()
    {
        return $this->hasMany(GenerationLog::class);
    }
}
