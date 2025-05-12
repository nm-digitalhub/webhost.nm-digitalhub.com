<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImpersonationLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_user_id',
        'impersonated_user_id',
        'started_at',
        'ended_at',
        'ip_address',
        'user_agent',
        'reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * Get the admin user who initiated the impersonation.
     */
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    /**
     * Get the user who was impersonated.
     */
    public function impersonatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'impersonated_user_id');
    }

    /**
     * Check if the impersonation session is currently active
     */
    public function isActive(): bool
    {
        return $this->ended_at === null;
    }

    /**
     * End the impersonation session
     */
    public function end(): void
    {
        $this->update(['ended_at' => now()]);
    }

    /**
     * Get the duration of the impersonation session
     */
    public function getDuration(): string
    {
        $duration = $this->ended_at ? $this->ended_at->diff($this->started_at) : now()->diff($this->started_at);

        return $duration->format('%H:%I:%S');
    }

    /**
     * Scope query to only include active impersonation sessions
     */
    public function scopeActive($query)
    {
        return $query->whereNull('ended_at');
    }
}