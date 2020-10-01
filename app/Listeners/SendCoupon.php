<?php

namespace App\Listeners;

use App\Models\Subscriber;
use App\Notifications\WelcomeFrontLinePhpWaitingListNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Mailcoach\Events\SubscribedEvent;
use Spatie\Mailcoach\Models\Subscriber as MailcoachSubscriber;


class SendCoupon
{
    public function handle(SubscribedEvent $event)
    {
        if ($event->subscriber->hasTag('front-line-php-waiting-list')) {

            $this->upcastSubscriber($event->subscriber)->notify(new WelcomeFrontLinePhpWaitingListNotification());

        }
    }

    protected function upcastSubscriber(MailcoachSubscriber $subscriber): Subscriber
    {
        return Subscriber::findByUuid($subscriber->uuid);
    }
}
