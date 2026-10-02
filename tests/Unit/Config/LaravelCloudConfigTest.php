<?php

use Illuminate\Support\Facades\Storage;

it('keeps files on local disks when not running on laravel cloud', function () {
    $disks = configWithEnvironment('filesystems.php', [])['disks'];

    expect($disks['medialibrary']['driver'])->toBe('local')
        ->and($disks['public']['driver'])->toBe('local')
        ->and($disks['purchasable_downloads']['driver'])->toBe('local')
        ->and($disks['docs']['driver'])->toBe('local')
        ->and($disks['docs-assets']['driver'])->toBe('local');
});

it('stores public files in the public bucket on laravel cloud', function () {
    $disks = configWithEnvironment('filesystems.php', ['LARAVEL_CLOUD' => '1'])['disks'];

    expect($disks['medialibrary'])->toMatchArray(['driver' => 'scoped', 'disk' => 'cloud-public', 'prefix' => 'medialibrary'])
        ->and($disks['public'])->toMatchArray(['driver' => 'scoped', 'disk' => 'cloud-public', 'prefix' => 'storage'])
        ->and($disks['docs-assets'])->toMatchArray(['driver' => 'scoped', 'disk' => 'cloud-public', 'prefix' => 'docs']);
});

it('stores private files in the private bucket on laravel cloud', function () {
    $disks = configWithEnvironment('filesystems.php', ['LARAVEL_CLOUD' => '1'])['disks'];

    expect($disks['purchasable_downloads'])->toMatchArray(['driver' => 'scoped', 'disk' => 'cloud-private', 'prefix' => 'purchasable-downloads'])
        ->and($disks['docs'])->toMatchArray(['driver' => 'scoped', 'disk' => 'cloud-private', 'prefix' => 'docs']);
});

it('generates urls in the bucket for the scoped disks', function () {
    $disks = configWithEnvironment('filesystems.php', ['LARAVEL_CLOUD' => '1'])['disks'];

    config()->set('filesystems.disks', array_merge($disks, [
        'cloud-public' => [
            'driver' => 's3',
            'key' => 'key',
            'secret' => 'secret',
            'region' => 'auto',
            'bucket' => 'public-bucket',
            'url' => 'https://public-bucket.example.com',
            'endpoint' => 'https://storage.example.com',
        ],
    ]));

    expect(Storage::disk('medialibrary')->url('12/image.jpg'))
        ->toBe('https://public-bucket.example.com/medialibrary/12/image.jpg');
});

it('reads the default cache store from CACHE_STORE before CACHE_DRIVER', function () {
    expect(configWithEnvironment('cache.php', ['CACHE_DRIVER' => 'redis'])['default'])->toBe('redis')
        ->and(configWithEnvironment('cache.php', ['CACHE_STORE' => 'database', 'CACHE_DRIVER' => 'redis'])['default'])->toBe('database');
});

it('does not use cache tags for geoip locations on laravel cloud', function () {
    expect(configWithEnvironment('geoip.php', [])['cache_tags'])->toBe(['torann-geoip-location'])
        ->and(configWithEnvironment('geoip.php', ['LARAVEL_CLOUD' => '1'])['cache_tags'])->toBeNull();
});

it('can look up a location while using the database cache without tags', function () {
    config()->set('cache.default', 'database');
    config()->set('geoip.cache_tags', null);

    expect(geoip('127.0.0.1')->iso_code)->toBeString();
});
