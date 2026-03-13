<?php

use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake([
        'https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/stable/latest-mac.yml' => Http::response(<<<'YML'
version: 3.1.0
files:
  - url: ray-3.1.0-latest-darwin-arm64.dmg
    sha512: abc123
    size: 119851354
  - url: ray-3.1.0-latest-darwin-x64.dmg
    sha512: def456
    size: 122240909
YML),
        'https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/stable/latest.yml' => Http::response(<<<'YML'
version: 3.1.0
files:
  - url: ray-3.1.0-latest-win32-x64-setup.exe
    sha512: abc123
    size: 102282264
YML),
        'https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/stable/latest-linux.yml' => Http::response(<<<'YML'
version: 3.1.0
files:
  - url: ray-3.1.0-latest-linux-x86_64.AppImage
    sha512: abc123
    size: 124330170
YML),
    ]);
});

it('redirects macOS arm64 downloads to S3 domain', function () {
    $this
        ->get('/products/ray/v3/download/macos-arm64/latest')
        ->assertRedirectContains('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/stable/ray-3.1.0-latest-darwin-arm64.dmg');
});

it('redirects macOS x64 downloads to S3 domain', function () {
    $this
        ->get('/products/ray/v3/download/macos-x64/latest')
        ->assertRedirectContains('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/stable/ray-3.1.0-latest-darwin-x64.dmg');
});

it('redirects Windows downloads to S3 domain', function () {
    $this
        ->get('/products/ray/v3/download/windows/latest')
        ->assertRedirectContains('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/stable/ray-3.1.0-latest-win32-x64-setup.exe');
});

it('redirects Linux downloads to S3 domain', function () {
    $this
        ->get('/products/ray/v3/download/linux/latest')
        ->assertRedirectContains('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v3/stable/ray-3.1.0-latest-linux-x86_64.AppImage');
});

it('returns 404 for invalid platforms', function () {
    $this
        ->get('/products/ray/v3/download/invalid/latest')
        ->assertNotFound();
});
