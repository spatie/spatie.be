<?php

use App\Models\License;
use App\Models\User;
use App\Notifications\LicenseExpiredNotification;
use App\Notifications\LicenseExpiredSecondNotification;
use App\Notifications\LicenseIsAboutToExpireNotification;

Route::prefix('mails')->group(function () {
    Route::get('license-expires-soon', function () {
        $notification = new LicenseIsAboutToExpireNotification(License::first());

        return $notification->toMail(User::first());
    });

    Route::get('license-expired', function () {
        $notification = new LicenseExpiredNotification(License::first());

        return $notification->toMail(User::first());
    });

    Route::get('license-expired-second', function () {
        $notification = new LicenseExpiredSecondNotification(License::first());

        return $notification->toMail(User::first());
    });
});
