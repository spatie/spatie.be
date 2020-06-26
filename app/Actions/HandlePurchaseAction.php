<?php

namespace App\Actions;

use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use App\Support\Paddle\PaddlePayload;
use Exception;

class HandlePurchaseAction
{
    protected CreateLicenseAction $createLicenseAction;

    public function __construct(CreateLicenseAction $createLicenseAction)
    {
        $this->createLicenseAction = $createLicenseAction;
    }

    public function execute(User $user, Purchasable $purchasable, PaddlePayload $paddlePayload): Purchase
    {
        $purchase = $this->createPurchase($user, $purchasable, $paddlePayload);

        $purchase = $this->handleLicensing($purchase);

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

    protected function handleLicensing(Purchase $purchase): Purchase
    {
        $purchasableToLicense = $purchase->purchasable->isRenewal()
            ? $purchase->purchasable->originalPurchasable
            : $purchase->purchasable;

        if ($purchase->purchasable->isRenewal()) {
            $this->ensureUserOwnsPurchasableToRenew($purchase->user, $purchasableToLicense);
        }

        $license = $this->createOrRenewLicense($purchase->user, $purchasableToLicense);

        $purchase->update(['license_id' => $license->id]);

        return $purchase;
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

    protected function ensureUserOwnsPurchasableToRenew(User $user, $purchasableToRenew): void
    {
        if (! $user->owns($purchasableToRenew)) {
            throw new Exception("User {$user->id} doesn't own purchasable {$purchasableToRenew->id} to renew.");
        }
    }
}
