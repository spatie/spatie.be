<?php

namespace App\Actions;

use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Str;

class CreateLicenseAction
{
    public function execute(User $user, Purchase $purchase, ?Purchasable $purchasable = null): License
    {
        return License::create([
            'key' => Str::random(64),
            'user_id' => $user->id,
            'purchase_id' => $purchase->id,
            'purchasable_id' => $purchasable ? $purchasable->id : $purchase->purchasable->id,
            'expires_at' => now()->addYear(),
        ]);
    }
}
