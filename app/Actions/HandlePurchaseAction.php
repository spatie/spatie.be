<?php

namespace App\Actions;

use App\Models\License;
use App\Models\Product;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use App\Support\Paddle\PaddlePayload;

class HandlePurchaseAction
{
    protected CreateLicenseAction $createLicenseAction;

    public function __construct(CreateLicenseAction $createLicenseAction)
    {
        $this->createLicenseAction = $createLicenseAction;
    }

    public function execute(User $user, Purchasable $purchasable, PaddlePayload $paddlePayload): Purchase
    {
        $licenseId = $purchasable->requires_license
            ? $this->createOrRenewLicense($user, $purchasable)->id
            : null;

        return Purchase::create([
            'license_id' => $licenseId,
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

    protected function createOrRenewLicense(User $user, Purchasable $purchasable): License
    {
        $license = License::query()
            ->where('purchasable_id', $purchasable->id)
            ->where('user_id', $user->id)
            ->first();

        if ($license !== null) {
            return $license->renew();
        }

        return $this->createLicenseAction->execute($user, $purchasable);
    }
}
