<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Mailcoach\Models\Subscriber as MailcoachSubscriber;

class Subscriber extends MailcoachSubscriber
{
    use Notifiable;

    public $guarded = [];
}
