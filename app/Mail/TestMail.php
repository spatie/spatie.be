<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\Mailcoach\Domain\TransactionalMail\Mails\Concerns\StoresMail;

class TestMail extends Mailable
{
    use Queueable, SerializesModels, StoresMail;

    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this
            ->trackOpensAndClicks()
            ->view('mails.test');
    }
}
