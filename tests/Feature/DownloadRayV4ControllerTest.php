<?php

use Illuminate\Support\Facades\Http;

function appcastItem(string $version, int $build, ?string $channel = null): string
{
    $channelTag = $channel ? "<sparkle:channel>{$channel}</sparkle:channel>" : '';

    return <<<XML
        <item>
            <title>Version {$version}</title>
            <sparkle:version>{$build}</sparkle:version>
            <sparkle:shortVersionString>{$version}</sparkle:shortVersionString>
            {$channelTag}
            <enclosure url="https://ray-app.s3.amazonaws.com/ray-app-updates-v4/mac/Ray-{$version}-universal-mac.zip" length="1" type="application/octet-stream" />
        </item>
XML;
}

function fakeAppcast(?string $items = null): void
{
    $items ??= implode("\n", [
        appcastItem('4.0.0', 713),
        appcastItem('4.0.1', 715),
        appcastItem('4.0.0-beta.9', 712, 'beta'),
        appcastItem('4.0.2-beta.0', 716, 'beta'),
    ]);

    Http::fake([
        'https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v4/mac/appcast.xml' => Http::response(<<<XML
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:sparkle="http://www.andymatuschak.org/xml-namespaces/sparkle">
    <channel>
        <title>Ray</title>
{$items}
    </channel>
</rss>
XML),
    ]);
}

it('redirects macOS downloads to the latest stable universal DMG', function (string $platform) {
    fakeAppcast();

    $this
        ->get("/products/ray/v4/download/{$platform}/latest")
        ->assertRedirect('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v4/mac/stable/ray-4.0.1-stable-mac-universal.dmg');
})->with(['macos', 'macos-arm64', 'macos-x64']);

it('redirects Windows downloads to the Velopack installer', function () {
    fakeAppcast();

    $this
        ->get('/products/ray/v4/download/windows/latest')
        ->assertRedirect('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v4/velopack/Ray-win-stable-Setup.exe');

    Http::assertNothingSent();
});

it('redirects Linux downloads to the AppImage', function () {
    fakeAppcast();

    $this
        ->get('/products/ray/v4/download/linux/latest')
        ->assertRedirect('https://ray-app.s3.eu-west-1.amazonaws.com/ray-app-updates-v4/velopack/Ray-linux-stable.AppImage');

    Http::assertNothingSent();
});

it('fails for macOS when the appcast has no stable release', function () {
    fakeAppcast(appcastItem('4.0.0-beta.9', 712, 'beta'));

    $this
        ->get('/products/ray/v4/download/macos/latest')
        ->assertStatus(500);
});

it('returns 404 for invalid platforms', function () {
    $this
        ->get('/products/ray/v4/download/invalid/latest')
        ->assertNotFound();
});
