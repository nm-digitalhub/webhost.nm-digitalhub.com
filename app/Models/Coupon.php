<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_value',
        'max_uses',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
        'description',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Coupon types
     */
    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENTAGE = 'percentage';

    /**
     * Check if the coupon is valid.
     */
    public function isValid(): bool
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check if started
        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }

        // Check if expired
        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }
        // Check if max uses reached
        return !($this->max_uses && $this->used_count >= $this->max_uses);
    }

    /**
     * Check if coupon is applicable to a cart.
     */
    public function isApplicable(Cart $cart): bool
    {
        // Check minimum order value
        return !($this->min_order_value && $cart->total < $this->min_order_value);
    }

    /**
     * Calculate discount amount for a given subtotal.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === self::TYPE_FIXED) {
            return min($subtotal, $this->value);
        } elseif ($this->type === self::TYPE_PERCENTAGE) {
            return $subtotal * ($this->value / 100);
        }

        return 0;
    }

    /**
     * Mark the coupon as used.
     */
    public function markAsUsed(): void
    {
        $this->increment('used_count');
    }

    /**
     * Scope a query to only include active coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include valid coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('used_count < max_uses');
            });
    }
}