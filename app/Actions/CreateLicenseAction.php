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
        $purchasableId = $purchasable ? $purchasable->id : $purchase->purchasable->id;

        return License::create([
            'key' => Str::random(64),
            'user_id' => $user->id,
            'purchase_id' => optional($purchase)->id,
            'purchasable_id' => $purchasableId,
            'expires_at' => $this->expiresAt($purchasableId),
        ]);
    }

    protected function expiresAt(int $purchasableId): Carbon
    {
        if ($purchasableId === 18) {
            return Carbon::createFromFormat('Y-m-d H:i:s', '2038-01-19 00:00:00');
        }

        return now()->addYear();
    }
}
