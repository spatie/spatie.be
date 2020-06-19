<?php

namespace App\Support\Paddle;

/**
 * Class PaddlePayload
 * @package App\Support\Paddle
 * @property string $alert_id
 * @property string $alert_name
 * @property string $balance_currency
 * @property string $balance_earnings
 * @property string $balance_fee
 * @property string $balance_gross
 * @property string $balance_tax
 * @property string $checkout_id
 * @property string $country
 * @property string $coupon
 * @property string $currency
 * @property string $customer_name
 * @property string $earnings
 * @property string $email
 * @property string $event_time
 * @property string $fee
 * @property string $ip
 * @property string $marketing_consent
 * @property string $order_id
 * @property string $passthrough
 * @property string $payment_method
 * @property string $payment_tax
 * @property string $product_id
 * @property string $product_name
 * @property string $quantity
 * @property string $receipt_url
 * @property string $sale_gross
 * @property string $used_price_override
 * @property string $p_signature
 */
class PaddlePayload
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function __get(string $name)
    {
        return $this->payload[$name] ?? null;
    }

    public function toArray(): array
    {
        return $this->payload;
    }
}
