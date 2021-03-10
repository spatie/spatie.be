<?php

namespace App\Actions;

use App\Models\User;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;

class UnsubscribeUserFromNewsletterAction
{
    public function execute(User $user): User
    {
        $emailList = EmailList::firstWhere('name', 'Spatie');

        if ($emailList->isSubscribed($user->email)) {
            $emailList->unsubscribe($user->email);
        }

        return $user;
    }
}
