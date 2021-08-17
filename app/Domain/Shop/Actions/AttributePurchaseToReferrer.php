<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\Referrer;

class AttributePurchaseToReferrer
{
    public function execute(Purchase $purchase, Referrer $referrer)
    {
        $referrer->usedForPurchases()->attach($purchase);

        Referrer::forgetActive();
    }
}
