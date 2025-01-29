<?php

namespace App\Actions;

use App\Models\User;
use App\Services\Mailcoach\MailcoachApi;

class SubscribeUserToNewsletterAction
{
    public function __construct(private readonly MailcoachApi $mailcoachApi)
    {
    }

    public function execute(User $user = null, string $email = null): ?User
    {
        $email ??= $user?->email;

        if (! $email) {
            return $user;
        }

        $subscriber = $this->mailcoachApi->getSubscriber($email);

        if (! $subscriber) {
            $subscriber = $this->mailcoachApi->subscribe(strtolower($email), skipConfirmation: true);
        }

        if ($subscriber) {
            $this->mailcoachApi->addTags($subscriber, ['newsletter']);
        }

        return $user;
    }
}
