<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\Purchase;
use App\Models\User;

class TransferPurchaseToUser
{
    public function execute(Purchase $purchase, User $user)
    {
        $purchase->assignments()->update(['user_id' => $user->id]);

        $purchase->update(['user_id' => $user->id]);

        $purchase->receipt()->update(['billable_id' => $user->id]);
    }
}
