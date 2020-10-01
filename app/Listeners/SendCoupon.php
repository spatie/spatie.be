<?php

namespace App\Listeners;

use App\Models\Subscriber;
use App\Notifications\WelcomeFrontLinePhpWaitingListNotification;
use Spatie\Mailcoach\Events\SubscribedEvent;
use Spatie\Mailcoach\Models\Subscriber as MailcoachSubscriber;

class SendCoupon
{
    public function handle(SubscribedEvent $event)
    {
        info('handling subscriber');
        if ($event->subscriber->hasTag('front-line-php-waiting-list')) {
            info('has right tag');
            $this->upcastSubscriber($event->subscriber)->notify(new WelcomeFrontLinePhpWaitingListNotification());
        }
    }

    protected function upcastSubscriber(MailcoachSubscriber $subscriber): Subscriber
    {
        return Subscriber::findByUuid($subscriber->uuid);
    }
}
