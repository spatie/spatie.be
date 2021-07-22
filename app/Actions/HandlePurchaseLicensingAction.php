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
        $purchase->getPurchasables()->each(function (Purchasable $purchasable) use ($purchase) {
            if ($purchasable->isRenewal()) {
                $this->handleRenewal($purchase);

                return;
            }

            if (! $purchasable->requires_license) {
                return;
            }

            foreach (range(1, $purchase->quantity) as $i) {
                $this->createLicenseAction->execute($purchase->user, $purchase, $purchasable);
            }
        });

        return $purchase;
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

        $license->renew();
    }

    protected function ensureUserOwnsPurchasableToRenew(User $user, Purchasable $purchasableToRenew): void
    {
        if (! $user->owns($purchasableToRenew)) {
            throw new Exception("User {$user->id} doesn't own purchasable {$purchasableToRenew->id} to renew.");
        }
    }
}
