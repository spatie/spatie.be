<?php

use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake([
        'https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/beta/darwin/universal/RELEASES.json' => Http::response([
            'currentRelease' => '1.0.0',
        ]),
    ]);
});

it('redirects macOS downloads to S3 domain', function () {
    $this
        ->get('/products/ray/v3/download/macos/latest')
        ->assertRedirectContains('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/beta/darwin/universal');
});

it('redirects Windows downloads to S3 domain', function () {
    $this
        ->get('/products/ray/v3/download/windows/latest')
        ->assertRedirectContains('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/beta/win32/x64');
});

it('redirects Linux downloads to S3 domain', function () {
    $this
        ->get('/products/ray/v3/download/linux/latest')
        ->assertRedirectContains('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/beta/linux/x64');
});

it('returns 404 for invalid platforms', function () {
    $this
        ->get('/products/ray/v3/download/invalid/latest')
        ->assertNotFound();
});
