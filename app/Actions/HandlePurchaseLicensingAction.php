<?php

namespace App\Actions;

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
        if ($purchase->license_id) {
            throw new Exception("Purchase {$purchase->id} already has a license ({$purchase->license_id})");
        }

        if (! $purchase->purchasable->requires_license) {
            return $purchase;
        }

        return $this->handleLicensing($purchase);
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
