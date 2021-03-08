<?php

namespace App\Actions;

use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CreateLicenseAction
{
    public function execute(User $user, ?Purchase $purchase = null, ?Purchasable $purchasable = null): License
    {
        ray('creating license');
        return License::create([
            'key' => Str::random(64),
            'user_id' => $user->id,
            'purchase_id' => optional($purchase)->id,
            'purchasable_id' => $purchasable ? $purchasable->id : $purchase->purchasable->id,
            'expires_at' => $this->expiresAt($purchasable),
        ]);
    }

    protected function expiresAt(?Purchasable $purchasable): Carbon
    {
        if (optional($purchasable)->id === 18) {
            return now()->addYears(20);
        }

        return now()->addYear();
    }
}
