<?php

namespace App\Actions;

use App\Models\User;
use App\Services\Mailcoach\MailcoachApi;

class UnsubscribeUserFromNewsletterAction
{
    public function __construct(private MailcoachApi $mailcoachApi)
    {
    }

    public function execute(User $user): User
    {
        $subscriber = $this->mailcoachApi->getSubscriber($user->email);

        if (! $subscriber) {
            return $user;
        }

        $this->mailcoachApi->unsubscribe($subscriber);

        return $user;
    }
}
