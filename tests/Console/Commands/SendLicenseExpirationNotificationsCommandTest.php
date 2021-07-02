<?php

namespace Tests\Console\Commands;

use App\Console\Commands\SendLicenseExpirationNotificationsCommand;
use App\Models\License;
use App\Notifications\LicenseExpiredNotification;
use App\Notifications\LicenseExpiredSecondNotification;
use App\Notifications\LicenseIsAboutToExpireNotification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendLicenseExpirationNotificationsCommandTest extends TestCase
{
    /** @test */
    public function it_sends_a_warning_notification_to_soon_to_expire_licenses()
    {
        Notification::fake();

        $licenseAboutToExpire = License::factory()->create(['expires_at' => now()->addDays(13)]);
        $licenseValidForALongTime = License::factory()->create(['expires_at' => now()->addMonth()]);

        Artisan::call(SendLicenseExpirationNotificationsCommand::class);

        Notification::assertSentTo($licenseAboutToExpire->user, LicenseIsAboutToExpireNotification::class);
        Notification::assertNotSentTo($licenseValidForALongTime->user, LicenseIsAboutToExpireNotification::class);
    }

    /** @test */
    public function it_wont_send_a_warning_notification_if_it_was_already_sent()
    {
        Notification::fake();

        $licenseAboutToExpire = License::factory()->create(['expires_at' => now()->addDays(13)]);

        Artisan::call(SendLicenseExpirationNotificationsCommand::class);
        Artisan::call(SendLicenseExpirationNotificationsCommand::class);

        Notification::assertSentToTimes($licenseAboutToExpire->user, LicenseIsAboutToExpireNotification::class, 1);
    }

    /** @test */
    public function it_sends_a_notification_to_expired_licenses()
    {
        Notification::fake();

        $expiredLicense = License::factory()->create(['expires_at' => now()->subHour()]);
        $licenseValidForALongTime = License::factory()->create(['expires_at' => now()->addMonth()]);

        Artisan::call(SendLicenseExpirationNotificationsCommand::class);

        Notification::assertSentTo($expiredLicense->user, LicenseExpiredNotification::class);
        Notification::assertNotSentTo($licenseValidForALongTime->user, LicenseExpiredNotification::class);
    }

    /** @test */
    public function it_wont_send_a_notification_if_it_was_already_sent()
    {
        Notification::fake();

        $expiredLicense = License::factory()->create(['expires_at' => now()->subHour()]);

        Artisan::call(SendLicenseExpirationNotificationsCommand::class);
        Artisan::call(SendLicenseExpirationNotificationsCommand::class);

        Notification::assertSentToTimes($expiredLicense->user, LicenseExpiredNotification::class, 1);
    }

    /** @test */
    public function it_sends_a_second_notification_to_expired_licenses()
    {
        Notification::fake();

        $expiredLicense = License::factory()->create(['expires_at' => now()->subDays(14)]);
        $recentlyExpiredLicense = License::factory()->create(['expires_at' => now()->subDays(2)]);

        Artisan::call(SendLicenseExpirationNotificationsCommand::class);

        Notification::assertSentTo($expiredLicense->user, LicenseExpiredSecondNotification::class);
        Notification::assertNotSentTo($recentlyExpiredLicense->user, LicenseExpiredSecondNotification::class);
    }

    /** @test */
    public function it_wont_send_a_second_notification_if_it_was_already_sent()
    {
        Notification::fake();

        $expiredLicense = License::factory()->create(['expires_at' => now()->subDays(14)]);

        Artisan::call(SendLicenseExpirationNotificationsCommand::class);
        Artisan::call(SendLicenseExpirationNotificationsCommand::class);

        Notification::assertSentToTimes($expiredLicense->user, LicenseExpiredSecondNotification::class, 1);
    }
}
