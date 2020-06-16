<?php

namespace App\Actions;

use App\Models\License;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;

class HandlePurchaseAction
{
    protected CreateLicenseAction $createLicenseAction;

    public function __construct(CreateLicenseAction $createLicenseAction)
    {
        $this->createLicenseAction = $createLicenseAction;
    }

    public function execute(User $user, Product $product, array $paddlePayload): Purchase
    {
        if ($product->requires_license) {
            $license = $this->createOrRenewLicense();
        }

        return Purchase::create([
            'license_id' => optional($license)->id,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'receipt_url' => $paddlePayload->receipt_url,
            'payment_method' => $paddlePayload->payment_method,
            'paddle_alert_id' => $paddlePayload->alert_id,
            'paddle_fee' => $paddlePayload->fee,
            'payment_tax' => $paddlePayload->payment_tax,
            'earnings' => $paddlePayload->earnings,
            'paddle_webhook_payload' => $paddlePayload->toArray(),
        ]);

    }

    protected function createOrRenewLicense(User $user, Product $product): License
    {
        if ($license = $user->licenses()->firstWhere('product_id', $product->id)) {
            return $license->renew();
        }

        return $this->createLicenseAction->execute($user, $product);
    }
}
