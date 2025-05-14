<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use App\Models\Order;
use App\Models\Transaction;

abstract class AbstractPaymentGateway implements PaymentGateway
{
    /**
     * Gateway configuration.
     */
    protected array $config = [];

    /**
     * Gateway mode (sandbox or production).
     */
    protected string $mode = 'sandbox';

    /**
     * Initialize the payment gateway with configuration.
     *
     * @return self
     */
    public function initialize(array $config): PaymentGateway
    {
        $this->config = $config;

        if (isset($config['mode'])) {
            $this->setMode($config['mode']);
        }

        return $this;
    }

    /**
     * Get the current gateway mode (sandbox/production).
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Set the gateway mode (sandbox/production).
     *
     * @return self
     */
    public function setMode(string $mode): PaymentGateway
    {
        $this->mode = in_array($mode, ['sandbox', 'production']) ? $mode : 'sandbox';

        return $this;
    }

    /**
     * Check if the gateway is configured correctly.
     */
    public function isConfigured(): bool
    {
        $requiredFields = $this->getRequiredConfigFields();

        foreach ($requiredFields as $field) {
            if (empty($this->config[$field])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get required configuration fields for this gateway.
     */
    abstract protected function getRequiredConfigFields(): array;

    /**
     * Create a transaction record for the order.
     *
     * @param  string  $providerId  External provider transaction ID
     * @param  string  $status  Transaction status
     * @param  array  $metadata  Additional metadata
     */
    protected function createTransactionRecord(
        Order $order,
        ?string $providerId = null,
        string $status = Transaction::STATUS_PENDING,
        array $metadata = []
    ): Transaction {
        return Transaction::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'transaction_id' => $providerId,
            'provider' => $this->getIdentifier(),
            'method' => Transaction::METHOD_CREDIT_CARD, // Default for now
            'amount' => $order->total,
            'currency' => $order->currency,
            'status' => $status,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Update a transaction record.
     *
     * @param  string  $status  New status
     * @param  string|null  $providerId  External provider transaction ID
     * @param  string|null  $errorMessage  Error message if any
     * @param  array  $metadata  Additional metadata to merge
     */
    protected function updateTransactionRecord(
        Transaction $transaction,
        string $status,
        ?string $providerId = null,
        ?string $errorMessage = null,
        array $metadata = []
    ): Transaction {
        $data = ['status' => $status];

        if ($providerId) {
            $data['transaction_id'] = $providerId;
        }

        if ($errorMessage) {
            $data['error_message'] = $errorMessage;
        }

        if ($metadata !== []) {
            $data['metadata'] = array_merge($transaction->metadata ?? [], $metadata);
        }

        $transaction->update($data);

        return $transaction->fresh();
    }

    /**
     * Update the order status based on transaction status.
     */
    protected function updateOrderStatus(Transaction $transaction): void
    {
        $order = $transaction->order;

        switch ($transaction->status) {
            case Transaction::STATUS_COMPLETED:
                $order->update(['status' => Order::STATUS_COMPLETED]);
                break;

            case Transaction::STATUS_FAILED:
                $order->update(['status' => Order::STATUS_FAILED]);
                break;

            case Transaction::STATUS_REFUNDED:
                $order->update(['status' => Order::STATUS_REFUNDED]);
                break;

            case Transaction::STATUS_CANCELLED:
                $order->update(['status' => Order::STATUS_CANCELLED]);
                break;

            case Transaction::STATUS_PENDING:
                // Only update if order was not already completed
                if (! in_array($order->status, [Order::STATUS_COMPLETED, Order::STATUS_REFUNDED])) {
                    $order->update(['status' => Order::STATUS_PROCESSING]);
                }
                break;
        }
    }
}
