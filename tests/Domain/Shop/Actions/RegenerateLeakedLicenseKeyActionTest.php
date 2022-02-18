<?php

use App\Domain\Shop\Actions\RegenerateLeakedLicenseKeyAction;
use App\Domain\Shop\Models\License;
use App\Mail\LeakedLicenseKeyRegeneratedMail;

it('can regenerate the license key and notify the assignee', function () {
    Mail::fake();

    $originalKey = 'original';

    $license = License::factory()->create([
       'key' => $originalKey,
   ]);

    (new RegenerateLeakedLicenseKeyAction())->execute($license, 'https://some-url.test');

    expect($license->refresh()->key)->not()->toBe($originalKey);

    Mail::assertQueued(LeakedLicenseKeyRegeneratedMail::class);
});
