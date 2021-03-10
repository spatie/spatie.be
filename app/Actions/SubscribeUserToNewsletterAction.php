<?php

namespace App\Actions;

use App\Models\User;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;

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
