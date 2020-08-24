<?php

namespace App\Actions;

use App\Models\User;
use Spatie\Mailcoach\Models\EmailList;

class SubscribeUserToNewsletterAction
{
    public function execute(User $user): User
    {
        $emailList = EmailList::firstWhere('name', 'Spatie');

        $emailList->subscribe($user->email);

        return $user;
    }
}
