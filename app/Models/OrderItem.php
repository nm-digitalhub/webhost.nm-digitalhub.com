<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'sku',
        'quantity',
        'price',
        'total',
        'options',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'options' => 'array',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that the order item represents.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Format the price with currency symbol.
     */
    public function formattedPrice(): string
    {
        $symbol = $this->order->currency === 'ILS' ? '₪' : ($this->order->currency === 'USD' ? '$' : '€');

        return $symbol.number_format($this->price, 2);
    }

    /**
     * Format the total with currency symbol.
     */
    public function formattedTotal(): string
    {
        $symbol = $this->order->currency === 'ILS' ? '₪' : ($this->order->currency === 'USD' ? '$' : '€');

        return $symbol.number_format($this->total, 2);
    }
}
