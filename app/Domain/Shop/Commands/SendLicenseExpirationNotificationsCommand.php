<?php

namespace App\Domain\Shop\Commands;

use Throwable;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Notifications\LicenseExpiredNotification;
use App\Domain\Shop\Notifications\LicenseExpiredSecondNotification;
use App\Domain\Shop\Notifications\LicenseIsAboutToExpireNotification;
use Illuminate\Console\Command;

class SendLicenseExpirationNotificationsCommand extends Command
{
    protected $signature = 'send-license-expirations';

    protected $description = 'Send license expiration notifications';

    public function handle(): void
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
                try {
                    $license->assignment?->user->notify(new LicenseIsAboutToExpireNotification($license));
                } catch (Throwable $e) {
                    report($e);
                }

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
                try {
                    $license->assignment?->user->notify(new LicenseExpiredNotification($license));
                } catch (Throwable $e) {
                    report($e);
                }
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
                try {
                    $license->assignment?->user->notify(new LicenseExpiredSecondNotification($license));
                } catch (Throwable $e) {
                    report($e);
                }
                $license->update(['second_expiration_mail_sent_at' => now()]);
            });

        return $this;
    }
}
