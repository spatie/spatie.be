<?php

namespace App\Actions;

use App\Models\User;
use App\Services\Mailcoach\MailcoachApi;

class SubscribeUserToNewsletterAction
{
    public function __construct(private MailcoachApi $mailcoachApi)
    {
    }

    public function execute(User $user): User
    {
        $this->mailcoachApi->subscribe($user->email, skipConfirmation: true);

        return $user;
    }
}
