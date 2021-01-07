<?php

namespace App\Actions;

use App\Mail\NextPurchaseDiscountPeriodStartedMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class StartOrExtendNextPurchaseDiscountPeriodAction
{
    public function execute(User $user)
    {
        $user->update([
            'next_purchase_discount_period_ends_at' => now()->addHours(24),
        ]);

        if ($user->email) {
            Mail::to($user->email)->queue(new NextPurchaseDiscountPeriodStartedMail($user));
        }
    }
}
