<?php

use App\Mail\RayTrialLicenseGrantedMail;

test('the purchase confirmation mail can be rendered', function () {
    $mailable = new RayTrialLicenseGrantedMail();

    expect($mailable->render())->toBeString();
});
