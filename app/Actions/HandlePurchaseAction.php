<?php

namespace App\Actions;

use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use App\Support\Paddle\PaddlePayload;

class HandlePurchaseAction
{
    protected HandlePurchaseLicensingAction $handlePurchaseLicensingAction;

    public function __construct(HandlePurchaseLicensingAction $handlePurchaseLicensingAction)
    {
        $this->handlePurchaseLicensingAction = $handlePurchaseLicensingAction;
    }

    public function execute(User $user, Purchasable $purchasable, PaddlePayload $paddlePayload): Purchase
    {
        $purchase = $this->createPurchase($user, $purchasable, $paddlePayload);

        $purchase = $this->handlePurchaseLicensingAction->execute($purchase);

        return $purchase;
    }

    protected function createPurchase(User $user, Purchasable $purchasable, PaddlePayload $paddlePayload): Purchase
    {
        return Purchase::create([
            'license_id' => null,
            'user_id' => $user->id,
            'purchasable_id' => $purchasable->id,
            'receipt_url' => $paddlePayload->receipt_url,
            'payment_method' => $paddlePayload->payment_method,
            'paddle_alert_id' => $paddlePayload->alert_id,
            'paddle_fee' => $paddlePayload->fee,
            'payment_tax' => $paddlePayload->payment_tax,
            'earnings' => $paddlePayload->earnings,
            'paddle_webhook_payload' => $paddlePayload->toArray(),
        ]);
    }
}
