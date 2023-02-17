<?php

namespace App\Actions;

use App\Domain\Shop\Actions\CreateLicenseAction;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Mail\RayTrialLicenseGrantedMail;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class GrantRayTrialLicenseAction
{
    public function __construct(
        protected CreateLicenseAction $createLicenseAction
    ) {
    }

    public function execute(User $user): ?License
    {
        // don't grant this anymore
        return null;

        if ($this->alreadyTriedRay($user)) {
            return null;
        }

        $rayPurchasable = Purchasable::query()->where('title', 'Ray license')->first();

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'purchasable_id' => $rayPurchasable->id,
            'paddle_fee' => 0,
            'earnings' => 0,
        ]);

        $assignment = PurchaseAssignment::create([
            'purchase_id' => $purchase->id,
            'purchasable_id' => $rayPurchasable->id,
            'user_id' => $user->id,
        ]);

        Mail::to($user->email)->send(new RayTrialLicenseGrantedMail());

        $licenseExpiresAt = now()->addMonth();

        return $this->createLicenseAction->execute($assignment, $licenseExpiresAt);
    }

    protected function alreadyTriedRay(User $user): bool
    {
        $rayPurchaseableIds = Purchasable::query()
            ->whereHas('product', function (Builder $query) {
                $query->where('title', 'Ray');
            })
            ->pluck('id');

        return $user
                ->assignments()
                ->whereIn('purchasable_id', $rayPurchaseableIds)
                ->exists();
    }
}
