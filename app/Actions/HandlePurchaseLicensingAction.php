<?php

namespace App\Actions;

use App\Exceptions\CouldNotRenewLicenseForPurchase;
use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use Exception;

class HandlePurchaseLicensingAction
{
    protected CreateLicenseAction $createLicenseAction;

    public function __construct(CreateLicenseAction $createLicenseAction)
    {
        $this->createLicenseAction = $createLicenseAction;
    }

    public function execute(Purchase $purchase): Purchase
    {
        ray('handling license')->model($purchase);
        if (! $purchase->purchasable->requires_license) {
            ray('does not require purchase')->red();
            return $purchase;
        }
        if ($purchase->purchasable->isRenewal()) {


            ray('is renewal')->green();
            $this->handleRenewal($purchase);

            return $purchase;
        }

        ray('purchase quantity', $purchase->quantity);
        foreach (range(1, $purchase->quantity) as $i) {
            ray('creating license')->blue();
            $this->createLicenseAction->execute($purchase->user, $purchase);
        }

        return $purchase;
    }

    protected function createOrRenewLicense(User $user, Purchasable $purchasable, bool $isRenewal): License
    {
        $license = License::query()
            ->where('purchasable_id', $purchasable->id)
            ->where('user_id', $user->id)
            ->first();

        if ($license !== null && $isRenewal) {
            return $license->renew();
        }

        return $this->createLicenseAction->execute($user, $purchasable);
    }

    protected function handleRenewal(Purchase $purchase): void
    {
        $this->ensureUserOwnsPurchasableToRenew(
            $purchase->user,
            $purchase->purchasable->originalPurchasable
        );

        $license = $purchase->wasMadeForLicense();
        if (! $license) {
            throw CouldNotRenewLicenseForPurchase::make($purchase);
        }
ray($license->expires_at);
        $license->renew();
        ray('renewing license')->model($license->fresh())->blue();
    }

    protected function ensureUserOwnsPurchasableToRenew(User $user, Purchasable $purchasableToRenew): void
    {
        if (! $user->owns($purchasableToRenew)) {
            throw new Exception("User {$user->id} doesn't own purchasable {$purchasableToRenew->id} to renew.");
        }
    }
}
