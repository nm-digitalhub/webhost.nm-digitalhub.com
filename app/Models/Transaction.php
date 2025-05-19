<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'transaction_id',
        'provider',
        'method',
        'amount',
        'currency',
        'status',
        'error_message',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    /**
     * Transaction statuses
     */
    public const STATUS_PENDING = 'pending';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_FAILED = 'failed';

    public const STATUS_REFUNDED = 'refunded';

    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Payment methods
     */
    public const METHOD_CREDIT_CARD = 'credit_card';

    public const METHOD_BANK_TRANSFER = 'bank_transfer';

    public const METHOD_PAYPAL = 'paypal';

    public const METHOD_APPLE_PAY = 'apple_pay';

    public const METHOD_GOOGLE_PAY = 'google_pay';

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order associated with the transaction.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get transactions with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get successful transactions.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Get failed transactions.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Format the amount with currency symbol.
     */
    public function formattedAmount(): string
    {
        $symbol = $this->currency === 'ILS' ? '₪' : ($this->currency === 'USD' ? '$' : '€');

        return $symbol.number_format($this->amount, 2);
    }
}
