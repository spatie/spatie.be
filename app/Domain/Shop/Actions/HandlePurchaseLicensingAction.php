<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Exceptions\CouldNotRenewLicenseForPurchase;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use RuntimeException;

class HandlePurchaseLicensingAction
{
    protected CreateLicenseAction $createLicenseAction;

    public function __construct(CreateLicenseAction $createLicenseAction)
    {
        $this->createLicenseAction = $createLicenseAction;
    }

    public function execute(Purchase $purchase): Purchase
    {
        $handledRenewal = false;

        $purchase->assignments()->each(function (PurchaseAssignment $assignment) use ($purchase, &$handledRenewal) {
            if ($assignment->purchasable->isRenewal()) {
                $this->handleRenewals($assignment, $purchase->quantity);
                $handledRenewal = true;

                return;
            }

            if (! $assignment->purchasable->requires_license) {
                return;
            }

            $this->createLicenseAction->execute($assignment);
        });

        if ($handledRenewal) {
            return $purchase;
        }

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

    protected function handleRenewals(PurchaseAssignment $assignment, int $quantity): void
    {
        $originalPurchasable = $assignment->purchasable->originalPurchasable;

        $this->ensureUserOwnsPurchasableToRenew($assignment->user, $originalPurchasable);

        $product = $originalPurchasable->product;
        $renewedLicenseIds = [];

        $specificLicense = $assignment->purchase->wasMadeForLicense();

        if ($specificLicense) {
            $specificLicense->renew();
            $renewedLicenseIds[] = $specificLicense->id;
        }

        $remainingToRenew = $quantity - count($renewedLicenseIds);

        if ($remainingToRenew > 0) {
            $licensesToRenew = $assignment->user
                ->licenses()
                ->forProduct($product)
                ->whereNotIn('licenses.id', $renewedLicenseIds)
                ->orderBy('expires_at')
                ->take($remainingToRenew)
                ->get();

            if ($licensesToRenew->isEmpty() && empty($renewedLicenseIds)) {
                throw CouldNotRenewLicenseForPurchase::make($assignment->purchase);
            }

            foreach ($licensesToRenew as $license) {
                $license->renew();
                $renewedLicenseIds[] = $license->id;
            }
        }

        $newLicensesNeeded = $quantity - count($renewedLicenseIds);

        if ($newLicensesNeeded > 0) {
            $newAssignment = PurchaseAssignment::create([
                'user_id' => $assignment->user_id,
                'purchase_id' => $assignment->purchase_id,
                'purchasable_id' => $originalPurchasable->id,
            ]);

            for ($i = 0; $i < $newLicensesNeeded; $i++) {
                $this->createLicenseAction->execute($newAssignment);
            }
        }
    }

    protected function ensureUserOwnsPurchasableToRenew(User $user, Purchasable $purchasableToRenew): void
    {
        if (! $user->owns($purchasableToRenew)) {
            throw new RuntimeException("User {$user->id} doesn't own purchasable {$purchasableToRenew->id} to renew.");
        }
    }
}
