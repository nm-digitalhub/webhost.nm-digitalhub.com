<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'items_count',
        'total',
        'currency',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total' => 'decimal:2',
        'items_count' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart items for the cart.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Add product to cart.
     */
    public function addItem(Product $product, int $quantity = 1, array $options = []): CartItem
    {
        // Check if the item already exists in the cart
        $existingItem = $this->items()
            ->where('product_id', $product->id)
            ->where('options', json_encode($options))
            ->first();

        if ($existingItem) {
            // Update quantity if item exists
            $existingItem->increment('quantity', $quantity);
            $cartItem = $existingItem;
        } else {
            // Create new cart item
            $cartItem = $this->items()->create([
                'product_id' => $product->id,
                'price' => $product->getEffectivePrice(),
                'quantity' => $quantity,
                'options' => $options,
            ]);
        }

        // Update cart totals
        $this->refreshTotals();

        return $cartItem;
    }

    /**
     * Update cart item quantity.
     */
    public function updateItemQuantity(int $cartItemId, int $quantity): ?CartItem
    {
        $cartItem = $this->items()->find($cartItemId);

        if ($cartItem) {
            if ($quantity <= 0) {
                $cartItem->delete();
                $this->refreshTotals();

                return null;
            }

            $cartItem->update(['quantity' => $quantity]);
            $this->refreshTotals();

            return $cartItem;
        }

        return null;
    }

    /**
     * Remove an item from the cart.
     */
    public function removeItem(int $cartItemId): bool
    {
        $result = $this->items()->where('id', $cartItemId)->delete();
        $this->refreshTotals();

        return $result > 0;
    }

    /**
     * Clear the cart.
     */
    public function clear(): void
    {
        $this->items()->delete();
        $this->refreshTotals();
    }

    /**
     * Refresh cart totals.
     */
    public function refreshTotals(): void
    {
        // Reload items relation
        $this->load('items');

        $itemsCount = $this->items->sum('quantity');
        $total = $this->items->sum(fn ($item) => $item->price * $item->quantity);

        $this->update([
            'items_count' => $itemsCount,
            'total' => $total,
        ]);
    }

    /**
     * Apply coupon to cart.
     */
    public function applyCoupon(Coupon $coupon): bool
    {
        // Check if coupon is valid
        if (! $coupon->isValid() || ! $coupon->isApplicable($this)) {
            return false;
        }

        // Store coupon in metadata
        $metadata = $this->metadata ?? [];
        $metadata['coupon'] = [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ];

        $this->update(['metadata' => $metadata]);

        return true;
    }

    /**
     * Remove coupon from cart.
     */
    public function removeCoupon(): void
    {
        $metadata = $this->metadata ?? [];
        unset($metadata['coupon']);
        $this->update(['metadata' => $metadata]);
    }

    /**
     * Get the applied coupon.
     */
    public function getAppliedCoupon(): ?array
    {
        return $this->metadata['coupon'] ?? null;
    }

    /**
     * Format the total with currency symbol.
     */
    public function formattedTotal(): string
    {
        $symbol = $this->currency === 'ILS' ? '₪' : ($this->currency === 'USD' ? '$' : '€');

        return $symbol . number_format($this->total, 2);
    }

    /**
     * Convert cart to order.
     */
    public function convertToOrder(array $orderData): ?Order
    {
        if ($this->items_count === 0) {
            return null;
        }

        // Create order
        $order = Order::create([
            'user_id' => $this->user_id,
            'order_number' => Order::generateOrderNumber(),
            'status' => Order::STATUS_PENDING,
            'total' => $this->total,
            'subtotal' => $this->total, // May need adjustment for tax/discount
            'currency' => $this->currency,
            'billing_name' => $orderData['billing_name'] ?? null,
            'billing_email' => $orderData['billing_email'] ?? null,
            'billing_phone' => $orderData['billing_phone'] ?? null,
            'billing_address' => $orderData['billing_address'] ?? null,
            'billing_city' => $orderData['billing_city'] ?? null,
            'billing_state' => $orderData['billing_state'] ?? null,
            'billing_zip' => $orderData['billing_zip'] ?? null,
            'billing_country' => $orderData['billing_country'] ?? null,
            'notes' => $orderData['notes'] ?? null,
            'metadata' => $this->metadata,
        ]);

        // Create order items
        foreach ($this->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'name' => $cartItem->product->name,
                'price' => $cartItem->price,
                'quantity' => $cartItem->quantity,
                'options' => $cartItem->options,
            ]);
        }

        // Clear the cart
        $this->clear();

        return $order;
    }
}
