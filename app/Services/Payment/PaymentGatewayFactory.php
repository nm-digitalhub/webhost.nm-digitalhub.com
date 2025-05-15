<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;

class PaymentGatewayFactory
{
    /**
     * List of supported payment gateways.
     */
    protected static array $gateways = [
        'cardcom' => CardcomGateway::class,
        'tranzila' => TranzilaGateway::class,
        // Additional gateways can be added here
    ];

    /**
     * Create a new payment gateway instance.
     *
     * @param  string  $gateway  Gateway identifier
     * @param  array  $config  Gateway configuration
     *
     * @throws \InvalidArgumentException
     */
    public static function create(string $gateway, array $config = []): PaymentGateway
    {
        if (! isset(self::$gateways[$gateway])) {
            throw new \InvalidArgumentException(sprintf('Payment gateway "%s" is not supported.', $gateway));
        }

        $gatewayClass = self::$gateways[$gateway];
        $instance = new $gatewayClass;

        if ($config !== []) {
            $instance->initialize($config);
        }

        return $instance;
    }

    /**
     * Register a new payment gateway.
     *
     * @param  string  $identifier  Gateway identifier
     * @param  string  $class  Gateway class name
     */
    public static function register(string $identifier, string $class): void
    {
        if (! class_exists($class) || ! is_subclass_of($class, PaymentGateway::class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" must implement PaymentGateway interface.', $class));
        }

        self::$gateways[$identifier] = $class;
    }

    /**
     * Get all supported gateways.
     */
    public static function getSupportedGateways(): array
    {
        $gateways = [];

        foreach (self::$gateways as $identifier => $class) {
            /** @var PaymentGateway $instance */
            $instance = new $class;

            $gateways[$identifier] = [
                'identifier' => $identifier,
                'name' => $instance->getName(),
            ];
        }

        return $gateways;
    }
}
