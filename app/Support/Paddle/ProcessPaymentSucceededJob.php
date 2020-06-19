<?php

namespace App\Support\Paddle;

use App\Actions\HandlePurchaseAction;
use App\Exceptions\CouldNotHandlePaymentSucceeded;
use App\Models\Product;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;

class ProcessPaymentSucceededJob
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function handle()
    {
        $paddlePayload = new PaddlePayload($this->payload);
        $passthrough = json_decode($paddlePayload->passthrough, true);
        $model = config('cashier.model');

        if ($paddlePayload->alert_name !== 'payment_succeeded') {
            return;
        }

        if (! $purchasable = Purchasable::where('paddle_product_id', $paddlePayload->product_id)->first()) {
            return;
        }

        if (Purchase::where('paddle_alert_id', $paddlePayload->alert_id)->first()) {
            return;
        }

        if (! $purchasable = Purchasable::where('paddle_product_id', $paddlePayload->product_id)->first()) {
            return;
        }

        if (! $user = (new $model)->find($passthrough['customer_id'])) {
            throw CouldNotHandlePaymentSucceeded::userNotFound($this->payload);
        }

        app(HandlePurchaseAction::class)->execute($user, $purchasable, $paddlePayload);
    }
}
