<?php

namespace App\Actions;

use App\Mail\PurchaseConfirmationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class StartOrExtendNextPurchaseDiscountPeriodAction
{
    public function execute(User $user)
    {
        $user->update([
            'next_purchase_discount_period_ends_at' => now()->addHours(24),
        ]);
    }
}
