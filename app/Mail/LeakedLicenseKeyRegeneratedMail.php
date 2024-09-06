<?php

namespace App\Mail;

use App\Domain\Shop\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\MailcoachMailer\Concerns\UsesMailcoachMail;

class LeakedLicenseKeyRegeneratedMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;
    use UsesMailcoachMail;

    public function __construct(
        public License $license,
        public string $foundOnUrl
    ) {
    }

    public function build(): void
    {
        $this
            ->mailcoachMail('spatie.leaked-license-key', [
                'url' => $this->foundOnUrl,
            ]);
    }
}
