<?php

use App\Domain\Shop\Models\License;
use App\Mail\LeakedLicenseKeyRegeneratedMail;

it('can render the LeakedLicenseKeyRegeneratedMail', function () {
    $license = License::factory()->create();

    $mail = new LeakedLicenseKeyRegeneratedMail($license, 'https://some-url.test');

    expect((string)$mail->build())->toBeString();
});
