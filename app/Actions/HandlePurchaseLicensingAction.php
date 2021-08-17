<?php

namespace App\Actions;

use App\Exceptions\CouldNotRenewLicenseForPurchase;
use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\PurchaseAssignment;
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
        $purchase->assignments()->each(function (PurchaseAssignment $assignment) use ($purchase) {
            if ($assignment->purchasable->isRenewal()) {
                $this->handleRenewal($assignment);

                return;
            }

            if (! $assignment->purchasable->requires_license) {
                return;
            }

            $this->createLicenseAction->execute($assignment);
        });

        if ($purchase->assignments()->count() < $purchase->quantity) {
            $assignment = $purchase->assignments->first();

            if (! $assignment->purchasable->requires_license) {
                return $purchase;
            }

            foreach (range($purchase->assignments()->count(), $purchase->quantity - 1) as $i) {
                $this->createLicenseAction->execute($assignment);
            }
        }

        return $purchase;
    }

    protected function handleRenewal(PurchaseAssignment $assignment): void
    {
        $this->ensureUserOwnsPurchasableToRenew(
            $assignment->user,
            $assignment->purchasable->originalPurchasable
        );

        $license = $assignment->purchase->wasMadeForLicense();
        if (! $license) {
            throw CouldNotRenewLicenseForPurchase::make($assignment->purchase);
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
