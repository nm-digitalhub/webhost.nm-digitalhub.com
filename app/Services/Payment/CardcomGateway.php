<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CardcomGateway extends AbstractPaymentGateway
{
    /**
     * API Base URLs
     */
    protected const SANDBOX_URL = 'https://sandbox.cardcom.solutions/Interface';

    protected const PRODUCTION_URL = 'https://secure.cardcom.solutions/Interface';

    /**
     * Get the payment gateway identifier.
     */
    public function getIdentifier(): string
    {
        return 'cardcom';
    }

    /**
     * Get the payment gateway display name.
     */
    public function getName(): string
    {
        return 'Cardcom (Israel)';
    }

    /**
     * Get required configuration fields for this gateway.
     */
    protected function getRequiredConfigFields(): array
    {
        return [
            'terminal_number',
            'username',
            'api_name',
            'api_password',
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
                'name' => 'terminal_number',
                'label' => 'Terminal Number',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'username',
                'label' => 'Username',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'api_name',
                'label' => 'API Name',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'api_password',
                'label' => 'API Password',
                'type' => 'password',
                'required' => true,
            ],
            [
                'name' => 'language',
                'label' => 'Language',
                'type' => 'select',
                'options' => [
                    'he' => 'Hebrew',
                    'en' => 'English',
                ],
                'default' => 'he',
            ],
            [
                'name' => 'page_styling',
                'label' => 'Custom CSS URL',
                'type' => 'text',
                'required' => false,
            ],
        ];
    }

    /**
     * Get the payment form fields.
     */
    public function getPaymentFields(): array
    {
        // Cardcom handles the payment form on their side
        return [];
    }

    /**
     * Create a payment session/transaction.
     *
     * @param  array  $paymentData  Additional payment data
     * @return array Payment session data
     */
    public function createPayment(Order $order, array $paymentData = []): array
    {
        if (! $this->isConfigured()) {
            throw new \Exception('Cardcom gateway is not properly configured');
        }

        $baseUrl = $this->mode === 'sandbox' ? self::SANDBOX_URL : self::PRODUCTION_URL;
        $terminalnumber = $this->config['terminal_number'];
        $username = $this->config['username'];
        $language = $this->config['language'] ?? 'he';

        // Create the API endpoint URL
        $url = "{$baseUrl}/UseRest.aspx";

        // Prepare the items for Cardcom
        $items = [];
        foreach ($order->items as $index => $item) {
            $items["Items[{$index}].Name"] = $item->name;
            $items["Items[{$index}].Price"] = $item->price;
            $items["Items[{$index}].Quantity"] = $item->quantity;
        }

        // Prepare the request data
        $requestData = array_merge([
            'TerminalNumber' => $terminalnumber,
            'UserName' => $username,
            'Operation' => 1, // Create page code
            'APIName' => $this->config['api_name'],
            'APIPassword' => $this->config['api_password'],
            'Language' => $language,
            'CoinID' => $order->currency === 'ILS' ? 1 : 2, // 1 for ILS, 2 for USD
            'SumToBill' => $order->total,
            'ProductName' => "Order #{$order->order_number}",
            'ReturnUrl' => route('checkout.callback', ['gateway' => $this->getIdentifier()]),
            'CancelUrl' => route('checkout.cancel', ['order_id' => $order->id]),
            'CardHolderName' => $order->billing_name,
            'CardHolderEmail' => $order->billing_email,
            'CardHolderPhone' => $order->billing_phone,
            'InvoiceHead.CustName' => $order->billing_name,
            'InvoiceHead.Email' => $order->billing_email,
            'InvoiceHead.PhoneNumber' => $order->billing_phone,
            'InvoiceHead.Address' => $order->billing_address,
            'InvoiceHead.City' => $order->billing_city,
            'InvoiceHead.Remarks' => $order->notes,
            // Skip the custom CSS for now
        ], $items);

        try {
            $response = Http::asForm()->post($url, $requestData);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['OperationResponse']['success']) && $data['OperationResponse']['success'] === true) {
                    // Create a transaction record
                    $transaction = $this->createTransactionRecord($order, null, Transaction::STATUS_PENDING, [
                        'cardcom_page_code' => $data['OperationResponse']['pagetokencode'],
                        'request_data' => $requestData,
                        'response_data' => $data,
                    ]);

                    return [
                        'success' => true,
                        'redirect_url' => $data['OperationResponse']['url'],
                        'transaction_id' => $transaction->id,
                        'provider_id' => $data['OperationResponse']['pagetokencode'],
                    ];
                } else {
                    $errorMessage = $data['OperationResponse']['message'] ?? 'Unknown error';
                    $this->createTransactionRecord(
                        $order,
                        null,
                        Transaction::STATUS_FAILED,
                        [
                            'request_data' => $requestData,
                            'response_data' => $data,
                            'error' => $errorMessage,
                        ]
                    );

                    return [
                        'success' => false,
                        'message' => $errorMessage,
                    ];
                }
            } else {
                $errorMessage = 'Failed to communicate with Cardcom. Status: '.$response->status();
                $this->createTransactionRecord(
                    $order,
                    null,
                    Transaction::STATUS_FAILED,
                    [
                        'request_data' => $requestData,
                        'error' => $errorMessage,
                    ]
                );

                return [
                    'success' => false,
                    'message' => $errorMessage,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Cardcom payment error: '.$e->getMessage(), [
                'order_id' => $order->id,
                'request_data' => $requestData,
            ]);

            $this->createTransactionRecord(
                $order,
                null,
                Transaction::STATUS_FAILED,
                [
                    'request_data' => $requestData,
                    'error' => $e->getMessage(),
                ]
            );

            return [
                'success' => false,
                'message' => 'An error occurred while processing your payment: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Process callback/webhook from payment gateway.
     *
     * @param  array  $data  Request data from callback
     */
    public function processCallback(array $data): Transaction
    {
        // Extract the Cardcom response data
        $isApproved = isset($data['ResponseCode']) && $data['ResponseCode'] === '0';
        $transactionId = $data['terminaltransactionnumber'] ?? null;
        $cardcomId = $data['lowprofilecode'] ?? null;

        // Try to find the transaction by the page code in metadata
        $transaction = Transaction::where('provider', $this->getIdentifier())
            ->whereJsonContains('metadata->cardcom_page_code', $data['lowprofilecode'] ?? '')
            ->first();

        if (! $transaction) {
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

        // Update the transaction status
        $status = $isApproved ? Transaction::STATUS_COMPLETED : Transaction::STATUS_FAILED;
        $errorMessage = $isApproved ? (null) : $data['ResponseText'] ?? 'Payment was not approved';

        $this->updateTransactionRecord(
            $transaction,
            $status,
            $transactionId,
            $errorMessage,
            [
                'cardcom_id' => $cardcomId,
                'callback_data' => $data,
                'approval_number' => $data['ApprovalNumber'] ?? null,
                'card_type' => $data['CardType'] ?? null,
                'card_brand' => $data['CardBrand'] ?? null,
                'card_expiration' => $data['CardExpiration'] ?? null,
                'card_foreign' => $data['CardForeign'] ?? null,
                'first_digits' => $data['FirstFourDigits'] ?? null,
                'last_digits' => $data['LastFourDigits'] ?? null,
            ]
        );

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
        if (! $transaction) {
            return false;
        }

        $baseUrl = $this->mode === 'sandbox' ? self::SANDBOX_URL : self::PRODUCTION_URL;
        $url = "{$baseUrl}/UseRest.aspx";

        $requestData = [
            'TerminalNumber' => $this->config['terminal_number'],
            'UserName' => $this->config['username'],
            'APIName' => $this->config['api_name'],
            'APIPassword' => $this->config['api_password'],
            'Operation' => 16, // Get transaction info
            'TransactionId' => $transaction->transaction_id,
        ];

        try {
            $response = Http::asForm()->post($url, $requestData);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['OperationResponse']['success']) && $data['OperationResponse']['success'] === true) {
                    // Verify the transaction status
                    $status = $data['OperationResponse']['status'] ?? '';

                    return in_array($status, ['Approved', 'Authorized']);
                }
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Cardcom verification error: '.$e->getMessage(), [
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
        // Cardcom automatically captures by default
        return true;
    }

    /**
     * Refund a payment.
     *
     * @param  float|null  $amount  Amount to refund (null for full refund)
     */
    public function refundPayment(Transaction $transaction, ?float $amount = null): bool
    {
        if (! $transaction->transaction_id) {
            return false;
        }

        $baseUrl = $this->mode === 'sandbox' ? self::SANDBOX_URL : self::PRODUCTION_URL;
        $url = "{$baseUrl}/UseRest.aspx";

        $requestData = [
            'TerminalNumber' => $this->config['terminal_number'],
            'UserName' => $this->config['username'],
            'APIName' => $this->config['api_name'],
            'APIPassword' => $this->config['api_password'],
            'Operation' => 7, // J5 - Refund operation
            'TransactionId' => $transaction->transaction_id,
            'CreditAmount' => $amount ?? $transaction->amount,
        ];

        try {
            $response = Http::asForm()->post($url, $requestData);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['OperationResponse']['success']) && $data['OperationResponse']['success'] === true) {
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
                    $errorMessage = $data['OperationResponse']['message'] ?? 'Unknown error';
                    Log::error('Cardcom refund error: '.$errorMessage, [
                        'transaction_id' => $transaction->id,
                        'response' => $data,
                    ]);

                    return false;
                }
            } else {
                Log::error('Cardcom refund request failed: '.$response->status(), [
                    'transaction_id' => $transaction->id,
                    'response' => $response->body(),
                ]);

                return false;
            }
        } catch (\Exception $e) {
            Log::error('Cardcom refund error: '.$e->getMessage(), [
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
        if (! $transaction->transaction_id) {
            return false;
        }

        $baseUrl = $this->mode === 'sandbox' ? self::SANDBOX_URL : self::PRODUCTION_URL;
        $url = "{$baseUrl}/UseRest.aspx";

        $requestData = [
            'TerminalNumber' => $this->config['terminal_number'],
            'UserName' => $this->config['username'],
            'APIName' => $this->config['api_name'],
            'APIPassword' => $this->config['api_password'],
            'Operation' => 8, // Cancel operation
            'TransactionId' => $transaction->transaction_id,
        ];

        try {
            $response = Http::asForm()->post($url, $requestData);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['OperationResponse']['success']) && $data['OperationResponse']['success'] === true) {
                    // Update the transaction status
                    $this->updateTransactionRecord(
                        $transaction,
                        Transaction::STATUS_CANCELLED,
                        null,
                        null,
                        [
                            'cancel_data' => $data,
                        ]
                    );

                    // Update the order status
                    $this->updateOrderStatus($transaction);

                    return true;
                } else {
                    $errorMessage = $data['OperationResponse']['message'] ?? 'Unknown error';
                    Log::error('Cardcom cancel error: '.$errorMessage, [
                        'transaction_id' => $transaction->id,
                        'response' => $data,
                    ]);

                    return false;
                }
            } else {
                Log::error('Cardcom cancel request failed: '.$response->status(), [
                    'transaction_id' => $transaction->id,
                    'response' => $response->body(),
                ]);

                return false;
            }
        } catch (\Exception $e) {
            Log::error('Cardcom cancel error: '.$e->getMessage(), [
                'transaction_id' => $transaction->id,
            ]);

            return false;
        }
    }

    /**
     * Get the redirect URL for payment processing.
     */
    public function getRedirectUrl(Transaction $transaction): ?string
    {
        $metadata = $transaction->metadata ?? [];

        return $metadata['response_data']['OperationResponse']['url'] ?? null;
    }
}
