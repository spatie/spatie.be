<?php

namespace App\Actions;

use App\Models\User;
use Spatie\Mailcoach\Models\EmailList;

class SubscribeUserToNewsletterAction
{
    public function execute(User $user): User
    {
        /** @todo how do we get the specific list? */
        $emailList = EmailList::first();
        $emailList->subscribe($user->email);

        return $user;
    }
}
