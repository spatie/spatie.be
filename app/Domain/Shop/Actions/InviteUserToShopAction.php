<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Notifications\AccountHasBeenCreatedNotification;
use App\Models\User;
use Illuminate\Support\Str;

class InviteUserToShopAction
{
    public function execute(User $purchaser, Purchasable|Bundle $purchasable, string $invitee): User
    {
        $user = User::create([
            'email' => $invitee,
            'name' => $invitee,
            'password' => bcrypt(Str::random(20)),
        ]);

        $user->notify(new AccountHasBeenCreatedNotification($purchaser, $purchasable));

        return $user;
    }
}
