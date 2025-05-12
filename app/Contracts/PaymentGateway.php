<?php

namespace App\Contracts;

use App\Models\Order;
use App\Models\Transaction;

interface PaymentGateway
{
    /**
     * Initialize the payment gateway with configuration.
     */
    public function initialize(array $config): self;
    
    /**
     * Get the payment gateway identifier.
     */
    public function getIdentifier(): string;
    
    /**
     * Get the payment gateway display name.
     */
    public function getName(): string;
    
    /**
     * Create a payment session/transaction.
     *
     * @param array $paymentData Additional payment data
     * @return array Payment session data
     */
    public function createPayment(Order $order, array $paymentData = []): array;
    
    /**
     * Process callback/webhook from payment gateway.
     *
     * @param array $data Request data from callback
     */
    public function processCallback(array $data): Transaction;
    
    /**
     * Verify a payment transaction.
     */
    public function verifyPayment(string $transactionId): bool;
    
    /**
     * Capture an authorized payment.
     */
    public function capturePayment(Transaction $transaction): bool;
    
    /**
     * Refund a payment.
     *
     * @param float|null $amount Amount to refund (null for full refund)
     */
    public function refundPayment(Transaction $transaction, ?float $amount = null): bool;
    
    /**
     * Cancel an authorized payment.
     */
    public function cancelPayment(Transaction $transaction): bool;
    
    /**
     * Check if the gateway is configured correctly.
     */
    public function isConfigured(): bool;
    
    /**
     * Get the configuration form fields.
     */
    public function getConfigFields(): array;
    
    /**
     * Get the payment form fields.
     */
    public function getPaymentFields(): array;
    
    /**
     * Get the redirect URL for payment processing.
     */
    public function getRedirectUrl(Transaction $transaction): ?string;
    
    /**
     * Get the current gateway mode (sandbox/production).
     */
    public function getMode(): string;
    
    /**
     * Set the gateway mode (sandbox/production).
     */
    public function setMode(string $mode): self;
}