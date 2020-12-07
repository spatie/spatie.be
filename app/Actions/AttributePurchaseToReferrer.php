<?php

namespace App\Actions;

use App\Models\Purchase;
use App\Models\Referrer;

class AttributePurchaseToReferrer
{
    public function execute(Purchase $purchase, Referrer $referrer)
    {
        $referrer->usedForPurchases()->attach($purchase);
    }
}
