<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber as MailcoachSubscriber;

class Subscriber extends MailcoachSubscriber
{
    use Notifiable;
}
