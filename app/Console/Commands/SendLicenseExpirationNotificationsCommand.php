<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Notifications\LicenseExpiredNotification;
use App\Notifications\LicenseIsAboutToExpireNotification;
use Illuminate\Console\Command;

class SendLicenseExpirationNotificationsCommand extends Command
{
    protected $signature = 'send-license-expirations';

    protected $description = 'Send license expiration notifications';

    public function handle(): void
    {
        $this
            ->sendNotificationsForLicensesThatAreAboutToExpire()
            ->sendNotificationsForLicensesThatHaveExpired();
    }

    protected function sendNotificationsForLicensesThatAreAboutToExpire(): self
    {
        License::query()
            ->where('expires_at', '<=', now()->addDays(14))
            ->whereNull('expiration_warning_mail_sent_at')
            ->each(function (License $license) {
                $license->user->notify(new LicenseIsAboutToExpireNotification($license));
                $license->update(['expiration_warning_mail_sent_at' => now()]);
            });

        return $this;
    }

    protected function sendNotificationsForLicensesThatHaveExpired(): self
    {
        License::query()
            ->where('expires_at', '<=', now())
            ->whereNull('expiration_mail_sent_at')
            ->each(function (License $license) {
                $license->user->notify(new LicenseExpiredNotification($license));
                $license->update(['expiration_mail_sent_at' => now()]);
            });

        return $this;
    }
}
