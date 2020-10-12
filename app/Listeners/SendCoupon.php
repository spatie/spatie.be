<?php

namespace App\Listeners;

use App\Models\Subscriber;
use App\Notifications\WelcomeFrontLinePhpWaitingListNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Mailcoach\Events\SubscribedEvent;
use Spatie\Mailcoach\Models\Subscriber as MailcoachSubscriber;

class SendCoupon
{
    public function handle(SubscribedEvent $event): void
    {
        if ($event->subscriber->hasTag('front-line-php-waiting-list')) {
            $this->upcastSubscriber($event->subscriber)->notify(new WelcomeFrontLinePhpWaitingListNotification());
        }
    }

    protected function upcastSubscriber(MailcoachSubscriber $subscriber): Subscriber
    {
        $subscriber = Subscriber::findByUuid($subscriber->uuid);

        if (! $subscriber) {
            throw (new ModelNotFoundException())->setModel(Subscriber::class);
        }

        return $subscriber;
    }
}
