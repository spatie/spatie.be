<?php

namespace App\Mail;

use App\Domain\Shop\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeakedLicenseKeyRegeneratedMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public License $license,
        public string $foundOnUrl
    ) {}

    public function build()
    {
        $this
            ->subject('We have revoked your leaked license key')
            ->markdown('mails.leakedLicenseKeyRegenerated');
    }
}
