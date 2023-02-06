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
        $subscriber = $this->mailcoachApi->getSubscriber($user->email);

        if (! $subscriber) {
            $subscriber = $this->mailcoachApi->subscribe(strtolower($user->email), skipConfirmation: true);
        }

        if ($subscriber) {
            $this->mailcoachApi->addTags($subscriber, ['newsletter']);
        }

        return $user;
    }
}
