<?php

namespace App\Actions;

use App\Models\User;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Subscriber;

class SubscribeUserToNewsletterAction
{
    public function execute(User $user): User
    {
        $emailList = EmailList::firstWhere('name', 'Spatie');

        Subscriber::createWithEmail($user->email)
            ->skipConfirmation()
            ->subscribeTo($emailList);

        return $user;
    }
}
