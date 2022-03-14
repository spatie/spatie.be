<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Exceptions\CouldNotRenewLicenseForPurchase;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
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
        $purchase->assignments()->each(function (PurchaseAssignment $assignment) {
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
            $product = $assignment->purchasable->originalPurchasable->product;

            $license = $assignment->user
                ->licenses()
                ->forProduct($product)
                ->orderBy('expires_at')
                ->first();
        }

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
