<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
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
        'price',
        'billing_cycle',
        'currency',
        'is_featured',
        'is_active',
        'sort_order',
        'metadata'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the features associated with the plan.
     */
    public function features(): HasMany
    {
        return $this->hasMany(PlanFeature::class);
    }

    /**
     * Get the products associated with this plan.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    
    /**
     * Format the price with currency symbol.
     */
    public function formattedPrice(): string
    {
        $symbol = $this->currency === 'ILS' ? '₪' : ($this->currency === 'USD' ? '$' : '€');
        return $symbol . number_format($this->price, 2);
    }
    
    /**
     * Get active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Get featured plans.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    /**
     * Order plans by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}