<?php

namespace App\Support\Paddle;

use App\Actions\HandlePurchaseAction;
use App\Exceptions\CouldNotHandlePaymentSucceeded;
use App\Models\Purchasable;
use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Paddle\Receipt;

class ProcessPaymentSucceededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        if (Receipt::where('order_id', $paddlePayload->order_id)->first()) {
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
