<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Notifications\LicenseExpiredNotification;
use App\Notifications\LicenseExpiredSecondNotification;
use App\Notifications\LicenseIsAboutToExpireNotification;
use Illuminate\Console\Command;

class SendLicenseExpirationNotificationsCommand extends Command
{
    protected $signature = 'send-license-expirations';

    protected $description = 'Send license expiration notifications';

    public function handle()
    {
        $this
            ->sendNotificationsForLicensesThatAreAboutToExpire()
            ->sendNotificationsForLicensesThatHaveExpired()
            ->sendSecondNotificationsForLicensesThatHaveExpired();
    }

    protected function sendNotificationsForLicensesThatAreAboutToExpire(): self
    {
        License::query()
            ->where('expires_at', '<=', now()->addDays(14))
            ->whereNull('expiration_warning_mail_sent_at')
            ->each(function (License $license): void {
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
            ->each(function (License $license): void {
                $license->user->notify(new LicenseExpiredNotification($license));
                $license->update(['expiration_mail_sent_at' => now()]);
            });

        return $this;
    }

    protected function sendSecondNotificationsForLicensesThatHaveExpired(): self
    {
        License::query()
            ->where('expires_at', '<=', now()->subDays(14))
            ->whereNull('second_expiration_mail_sent_at')
            ->each(function (License $license): void {
                $license->user->notify(new LicenseExpiredSecondNotification($license));
                $license->update(['second_expiration_mail_sent_at' => now()]);
            });

        return $this;
    }
}
