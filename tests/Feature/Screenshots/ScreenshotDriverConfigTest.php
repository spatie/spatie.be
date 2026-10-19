<?php

use App\Jobs\GenerateOgImageJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelScreenshot\Drivers\BrowsershotDriver;
use Spatie\LaravelScreenshot\Drivers\ScreenshotDriver;

it('uses browsershot by default', function () {
    expect(config('laravel-screenshot.driver'))->toBe('browsershot')
        ->and(app(ScreenshotDriver::class))->toBeInstanceOf(BrowsershotDriver::class);
});

it('selects the screenshot driver and its credentials using env variables', function () {
    $config = configWithEnvironment('laravel-screenshot.php', [
        'LARAVEL_SCREENSHOT_DRIVER' => 'cloudflare',
        'CLOUDFLARE_API_TOKEN' => 'cloudflare-token',
        'CLOUDFLARE_ACCOUNT_ID' => 'cloudflare-account',
    ]);

    expect($config['driver'])->toBe('cloudflare')
        ->and($config['cloudflare'])->toBe([
            'api_token' => 'cloudflare-token',
            'account_id' => 'cloudflare-account',
        ]);
});

it('reads the browsershot binary paths from env variables', function () {
    $config = configWithEnvironment('laravel-screenshot.php', [
        'LARAVEL_SCREENSHOT_CHROME_PATH' => '/opt/chrome/chrome',
        'LARAVEL_SCREENSHOT_NODE_BINARY' => '/usr/local/bin/node',
        'LARAVEL_SCREENSHOT_NPM_BINARY' => '/usr/local/bin/npm',
        'LARAVEL_SCREENSHOT_NO_SANDBOX' => 'true',
    ]);

    expect($config['browsershot'])
        ->chrome_path->toBe('/opt/chrome/chrome')
        ->node_binary->toBe('/usr/local/bin/node')
        ->npm_binary->toBe('/usr/local/bin/npm')
        ->no_sandbox->toBeTrue();
});

it('renders og images with the configured screenshot driver', function () {
    Storage::fake('public');

    config()->set('laravel-screenshot.driver', 'cloudflare');
    config()->set('laravel-screenshot.cloudflare', ['api_token' => 'token', 'account_id' => 'account']);

    Http::fake([
        'api.cloudflare.com/*' => Http::response('jpeg-bytes'),
    ]);

    Cache::forever('og-image:abc123', ['url' => 'https://spatie.be/open-source']);

    (new GenerateOgImageJob('abc123', 'jpeg'))->handle();

    Http::assertSent(fn ($request) => $request->url() === 'https://api.cloudflare.com/client/v4/accounts/account/browser-rendering/screenshot'
        && $request['url'] === 'https://spatie.be/open-source?ogimage='
        && $request['screenshotOptions']['type'] === 'jpeg');

    Storage::disk('public')->assertExists('og-images/abc123.jpeg');
});
