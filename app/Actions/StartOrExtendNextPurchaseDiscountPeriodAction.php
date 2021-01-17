<?php

namespace App\Actions;

use App\Models\User;

class StartOrExtendNextPurchaseDiscountPeriodAction
{
    public function execute(User $user)
    {
        $user->update([
            'next_purchase_discount_period_ends_at' => now()->addHours(24),
        ]);
    }
}
