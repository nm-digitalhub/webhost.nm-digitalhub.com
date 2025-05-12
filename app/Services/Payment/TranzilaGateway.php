<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranzilaGateway extends AbstractPaymentGateway
{
    /**
     * API Base URLs
     */
    protected const SANDBOX_URL = 'https://sandbox.tranzila.com';
    protected const PRODUCTION_URL = 'https://secure5.tranzila.com';
    
    /**
     * Get the payment gateway identifier.
     */
    public function getIdentifier(): string
    {
        return 'tranzila';
    }
    
    /**
     * Get the payment gateway display name.
     */
    public function getName(): string
    {
        return 'Tranzila (Israel)';
    }
    
    /**
     * Get required configuration fields for this gateway.
     */
    protected function getRequiredConfigFields(): array
    {
        return [
            'terminal_name',
            'supplier_code',
        ];
    }
    
    /**
     * Get the configuration form fields.
     */
    public function getConfigFields(): array
    {
        return [
            [
                'name' => 'mode',
                'label' => 'Environment Mode',
                'type' => 'select',
                'options' => [
                    'sandbox' => 'Sandbox',
                    'production' => 'Production',
                ],
                'required' => true,
            ],
            [
                'name' => 'terminal_name',
                'label' => 'Terminal Name',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'supplier_code',
                'label' => 'Supplier Code',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'language',
                'label' => 'Language',
                'type' => 'select',
                'options' => [
                    'il' => 'Hebrew',
                    'en' => 'English',
                ],
                'default' => 'il',
            ],
            [
                'name' => 'cred_type',
                'label' => 'Credit Card Type',
                'type' => 'select',
                'options' => [
                    '1' => 'Regular',
                    '6' => 'Installments',
                ],
                'default' => '1',
            ],
        ];
    }
    
    /**
     * Get the payment form fields.
     */
    public function getPaymentFields(): array
    {
        // Tranzila handles the payment form on their side
        return [];
    }
    
    /**
     * Create a payment session/transaction.
     *
     * @param array $paymentData Additional payment data
     * @return array Payment session data
     */
    public function createPayment(Order $order, array $paymentData = []): array
    {
        if (!$this->isConfigured()) {
            throw new \Exception('Tranzila gateway is not properly configured');
        }
        
        $terminalName = $this->config['terminal_name'];
        $supplierCode = $this->config['supplier_code'];
        $language = $this->config['language'] ?? 'il';
        $credType = $this->config['cred_type'] ?? '1';
        
        // Format the sum in the required format (no decimal point)
        $sum = number_format($order->total * 100, 0, '', '');
        
        // Create a unique order ID for Tranzila (with random string to avoid duplicates)
        $orderIdForTranzila = $order->id . '-' . substr(md5(uniqid()), 0, 6);
        
        // Base URL for the Tranzila hosted payment page
        $baseUrl = $this->mode === 'sandbox' ? self::SANDBOX_URL : self::PRODUCTION_URL;
        
        // Building the payment URL
        $queryParams = http_build_query([
            'supplier' => $terminalName,
            'sum' => $sum,
            'currency' => $order->currency === 'ILS' ? '1' : '2', // 1 for ILS, 2 for USD
            'tranmode' => $credType,
            'lang' => $language,
            'buttonlabel' => 'Complete Payment',
            'cfield1' => $order->order_number,
            'email' => $order->billing_email,
            'contact' => $order->billing_name,
            'phone' => $order->billing_phone,
            'address' => $order->billing_address,
            'city' => $order->billing_city,
            'remarks' => $order->notes,
            'suppliercode' => $supplierCode,
            'pdesc' => "Order #{$order->order_number}",
            'success_url_address' => route('checkout.callback', ['gateway' => $this->getIdentifier()]),
            'fail_url_address' => route('checkout.cancel', ['order_id' => $order->id]),
            'notify_url' => route('checkout.notify', ['gateway' => $this->getIdentifier()]),
        ]);
        
        $redirectUrl = $baseUrl . '/cgi-bin/tranzila71u.cgi?' . $queryParams;
        
        // Create transaction record
        $transaction = $this->createTransactionRecord($order, null, Transaction::STATUS_PENDING, [
            'tranzila_order_id' => $orderIdForTranzila,
            'redirect_url' => $redirectUrl,
            'request_data' => [
                'terminal_name' => $terminalName,
                'supplier_code' => $supplierCode,
                'sum' => $sum,
                'currency' => $order->currency,
                'order_id' => $orderIdForTranzila,
            ],
        ]);
        
        return [
            'success' => true,
            'redirect_url' => $redirectUrl,
            'transaction_id' => $transaction->id,
        ];
    }
    
    /**
     * Process callback/webhook from payment gateway.
     *
     * @param array $data Request data from callback
     */
    public function processCallback(array $data): Transaction
    {
        // Extract the Tranzila response data
        $isApproved = isset($data['Response']) && $data['Response'] === '000';
        $tranzilaId = $data['index'] ?? null;
        $orderId = $data['cfield1'] ?? null;
        
        // Try to find the order and its transaction
        $order = Order::where('order_number', $orderId)->first();
        
        if (!$order) {
            // Create a new transaction record for logging
            $transaction = Transaction::create([
                'provider' => $this->getIdentifier(),
                'status' => Transaction::STATUS_FAILED,
                'error_message' => 'Could not match transaction to an order',
                'metadata' => [
                    'callback_data' => $data,
                ],
            ]);
            
            return $transaction;
        }
        
        // Find the pending transaction for this order
        $transaction = Transaction::where('order_id', $order->id)
            ->where('provider', $this->getIdentifier())
            ->where('status', Transaction::STATUS_PENDING)
            ->latest()
            ->first();
            
        if (!$transaction) {
            // Create a new transaction record
            $transaction = $this->createTransactionRecord(
                $order,
                $tranzilaId,
                $isApproved ? Transaction::STATUS_COMPLETED : Transaction::STATUS_FAILED,
                [
                    'callback_data' => $data,
                ]
            );
        } else {
            // Update the existing transaction
            $status = $isApproved ? Transaction::STATUS_COMPLETED : Transaction::STATUS_FAILED;
            $errorMessage = $isApproved ? (null) : $data['errmsg'] ?? 'Payment was not approved';
            
            $this->updateTransactionRecord(
                $transaction,
                $status,
                $tranzilaId,
                $errorMessage,
                [
                    'callback_data' => $data,
                    'approval_code' => $data['AuthCode'] ?? null,
                    'card_type' => $data['cardtype'] ?? null,
                    'card_brand' => $data['Cardtype'] ?? null,
                    'card_expiration' => $data['expmonth'] . '/' . $data['expyear'] ?? null,
                    'last_digits' => $data['last4digits'] ?? null,
                    'auth_number' => $data['AuthCode'] ?? null,
                ]
            );
        }
        
        // Update the order status
        $this->updateOrderStatus($transaction);
        
        return $transaction;
    }
    
    /**
     * Verify a payment transaction.
     */
    public function verifyPayment(string $transactionId): bool
    {
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            return false;
        }
        
        $baseUrl = $this->mode === 'sandbox' ? self::SANDBOX_URL : self::PRODUCTION_URL;
        $url = "{$baseUrl}/cgi-bin/tranzila33a.cgi";
        
        $requestData = [
            'supplier' => $this->config['terminal_name'],
            'index' => $transaction->transaction_id,
            'TranzilaPW' => $this->config['supplier_code'],
        ];
        
        try {
            $response = Http::asForm()->post($url, $requestData);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['Response']) && $data['Response'] === '000') {
                    return true;
                }
            }
            
            return false;
            
        } catch (\Exception $e) {
            Log::error('Tranzila verification error: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
            ]);
            
            return false;
        }
    }
    
    /**
     * Capture an authorized payment.
     */
    public function capturePayment(Transaction $transaction): bool
    {
        // Tranzila automatically captures by default
        return true;
    }
    
    /**
     * Refund a payment.
     *
     * @param float|null $amount Amount to refund (null for full refund)
     */
    public function refundPayment(Transaction $transaction, ?float $amount = null): bool
    {
        if (!$transaction->transaction_id) {
            return false;
        }
        
        $baseUrl = $this->mode === 'sandbox' ? self::SANDBOX_URL : self::PRODUCTION_URL;
        $url = "{$baseUrl}/cgi-bin/tranzila35a.cgi";
        
        // Format amount in the required format (no decimal point)
        $refundAmount = $amount ? number_format($amount * 100, 0, '', '') : null;
        
        $requestData = [
            'supplier' => $this->config['terminal_name'],
            'index' => $transaction->transaction_id,
            'TranzilaPW' => $this->config['supplier_code'],
            'tranmode' => 'C', // Credit operation
        ];
        
        if ($refundAmount) {
            $requestData['sum'] = $refundAmount;
        }
        
        try {
            $response = Http::asForm()->post($url, $requestData);
            
            if ($response->successful()) {
                $data = $response->body();
                
                if (str_contains($data, 'Response=000')) {
                    // Update the transaction status
                    $this->updateTransactionRecord(
                        $transaction,
                        Transaction::STATUS_REFUNDED,
                        null,
                        null,
                        [
                            'refund_data' => $data,
                            'refund_amount' => $amount ?? $transaction->amount,
                        ]
                    );
                    
                    // Update the order status
                    $this->updateOrderStatus($transaction);
                    
                    return true;
                } else {
                    Log::error('Tranzila refund error: ' . $data, [
                        'transaction_id' => $transaction->id,
                    ]);
                    
                    return false;
                }
            } else {
                Log::error('Tranzila refund request failed: ' . $response->status(), [
                    'transaction_id' => $transaction->id,
                    'response' => $response->body(),
                ]);
                
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error('Tranzila refund error: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id,
            ]);
            
            return false;
        }
    }
    
    /**
     * Cancel an authorized payment.
     */
    public function cancelPayment(Transaction $transaction): bool
    {
        // For Tranzila, cancellation is the same as refund
        return $this->refundPayment($transaction);
    }
    
    /**
     * Get the redirect URL for payment processing.
     */
    public function getRedirectUrl(Transaction $transaction): ?string
    {
        $metadata = $transaction->metadata ?? [];
        
        return $metadata['redirect_url'] ?? null;
    }
}