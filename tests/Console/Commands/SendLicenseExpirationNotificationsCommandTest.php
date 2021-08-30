<?php

use App\Domain\Shop\Commands\SendLicenseExpirationNotificationsCommand;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Notifications\LicenseExpiredNotification;
use App\Domain\Shop\Notifications\LicenseExpiredSecondNotification;
use App\Domain\Shop\Notifications\LicenseIsAboutToExpireNotification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;



it('sends a warning notification to soon to expire licenses', function () {
    Notification::fake();

    $licenseAboutToExpire = License::factory()->create(['expires_at' => now()->addDays(13)]);
    $licenseValidForALongTime = License::factory()->create(['expires_at' => now()->addMonth()]);

    Artisan::call(SendLicenseExpirationNotificationsCommand::class);

    Notification::assertSentTo($licenseAboutToExpire->assignment->user, LicenseIsAboutToExpireNotification::class);
    Notification::assertNotSentTo($licenseValidForALongTime->assignment->user, LicenseIsAboutToExpireNotification::class);
});

it('wont send a warning notification if it was already sent', function () {
    Notification::fake();

    $licenseAboutToExpire = License::factory()->create(['expires_at' => now()->addDays(13)]);

    Artisan::call(SendLicenseExpirationNotificationsCommand::class);
    Artisan::call(SendLicenseExpirationNotificationsCommand::class);

    Notification::assertSentToTimes($licenseAboutToExpire->assignment->user, LicenseIsAboutToExpireNotification::class, 1);
});

it('sends a notification to expired licenses', function () {
    Notification::fake();

    $expiredLicense = License::factory()->create(['expires_at' => now()->subHour()]);
    $licenseValidForALongTime = License::factory()->create(['expires_at' => now()->addMonth()]);

    Artisan::call(SendLicenseExpirationNotificationsCommand::class);

    Notification::assertSentTo($expiredLicense->assignment->user, LicenseExpiredNotification::class);
    Notification::assertNotSentTo($licenseValidForALongTime->assignment->user, LicenseExpiredNotification::class);
});

it('wont send a notification if it was already sent', function () {
    Notification::fake();

    $expiredLicense = License::factory()->create(['expires_at' => now()->subHour()]);

    Artisan::call(SendLicenseExpirationNotificationsCommand::class);
    Artisan::call(SendLicenseExpirationNotificationsCommand::class);

    Notification::assertSentToTimes($expiredLicense->assignment->user, LicenseExpiredNotification::class, 1);
});

it('sends a second notification to expired licenses', function () {
    Notification::fake();

    $expiredLicense = License::factory()->create(['expires_at' => now()->subDays(14)]);
    $recentlyExpiredLicense = License::factory()->create(['expires_at' => now()->subDays(2)]);

    Artisan::call(SendLicenseExpirationNotificationsCommand::class);

    Notification::assertSentTo($expiredLicense->assignment->user, LicenseExpiredSecondNotification::class);
    Notification::assertNotSentTo($recentlyExpiredLicense->assignment->user, LicenseExpiredSecondNotification::class);
});

it('wont send a second notification if it was already sent', function () {
    Notification::fake();

    $expiredLicense = License::factory()->create(['expires_at' => now()->subDays(14)]);

    Artisan::call(SendLicenseExpirationNotificationsCommand::class);
    Artisan::call(SendLicenseExpirationNotificationsCommand::class);

    Notification::assertSentToTimes($expiredLicense->assignment->user, LicenseExpiredSecondNotification::class, 1);
});
