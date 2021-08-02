<?php

namespace App\Support\Paddle;

use App\Actions\HandleBundlePurchaseAction;
use App\Actions\HandlePurchaseAction;
use App\Exceptions\CouldNotHandlePaymentSucceeded;
use App\Models\Bundle;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\Referrer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Paddle\Receipt;

class ProcessPaymentSucceededJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function handle()
    {
        $paddlePayload = new PaddlePayload($this->payload);

        $passthrough = json_decode($paddlePayload->passthrough, true);

        if ($paddlePayload->alert_name !== 'payment_succeeded') {
            return;
        }

        $purchasable = isset($passthrough['product_id'])
            ? Purchasable::where('paddle_product_id', $passthrough['product_id'])->first()
            : null;
        $bundle = isset($passthrough['bundle_id'])
            ? Bundle::where('paddle_product_id', $passthrough['bundle_id'])->first()
            : null;

        if (! $purchasable && ! $bundle) {
            return;
        }

        if (! $receipt = Receipt::where('order_id', $paddlePayload->order_id)->first()) {
            return;
        }

        if (! $user = (new $passthrough['billable_type'])->find($passthrough['billable_id'])) {
            throw CouldNotHandlePaymentSucceeded::userNotFound($this->payload);
        }

        if ($purchasable) {
            $purchaseForPurchasable = Purchase::where('user_id', $user->id)
                ->where('purchasable_id', $purchasable->id)
                ->where('receipt_id', $receipt->id)
                ->exists();

            if ($purchaseForPurchasable) {
                return;
            }
        }

        if ($bundle) {
            $purchaseForBundle = Purchase::where('user_id', $user->id)
                ->where('bundle_id', $bundle->id)
                ->where('receipt_id', $receipt->id)
                ->exists();

            if ($purchaseForBundle) {
                return;
            }
        }

        app(HandlePurchaseAction::class)->execute(
            $user,
            $bundle ?? $purchasable,
            $paddlePayload,
            $this->determineReferrer($passthrough),
        );
    }

    protected function determineReferrer($passthrough): ?Referrer
    {
        if (! isset($passthrough['referrer_uuid'])) {
            return null;
        }

        return Referrer::firstWhere('uuid', $passthrough['referrer_uuid']);
    }
}
