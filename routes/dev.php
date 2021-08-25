<?php

use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Notifications\AccountHasBeenCreatedNotification;
use App\Domain\Shop\Notifications\LicenseExpiredNotification;
use App\Domain\Shop\Notifications\LicenseExpiredSecondNotification;
use App\Domain\Shop\Notifications\LicenseIsAboutToExpireNotification;
use App\Models\User;

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

    Route::get('invitation', function () {
        $notification = new AccountHasBeenCreatedNotification(User::skip(1)->first(), Purchasable::first());

        return $notification->toMail(User::skip(1)->first());
    });
});
