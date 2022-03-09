<?php

namespace App\Mail;

use App\Domain\Shop\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RayTrialLicenseGrantedMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function build()
    {
        $this
            ->subject('Debug faster using your new Ray license')
            ->markdown('mails.rayTrialLicenseGranted');
    }
}
