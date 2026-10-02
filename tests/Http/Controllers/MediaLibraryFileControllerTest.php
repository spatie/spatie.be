<?php

use Illuminate\Support\Facades\Storage;
use Spatie\OgImage\Facades\OgImage;

it('does not handle media library urls when the files are on a local disk', function () {
    $this->get('images/medialibrary/12/image.jpg')->assertNotFound();
});

it('redirects media library urls to the bucket', function () {
    config()->set('filesystems.disks.cloud-public', [
        'driver' => 's3',
        'key' => 'key',
        'secret' => 'secret',
        'region' => 'auto',
        'bucket' => 'public-bucket',
        'url' => 'https://public-bucket.example.com',
        'endpoint' => 'https://storage.example.com',
    ]);
    config()->set('filesystems.disks.medialibrary', [
        'driver' => 'scoped',
        'disk' => 'cloud-public',
        'prefix' => 'medialibrary',
    ]);
    Storage::forgetDisk('medialibrary');

    OgImage::fallbackUsing(fn () => null);

    $this->get('images/medialibrary/12/responsive-images/image___media_library_original_100_50.jpg')
        ->assertRedirect('https://public-bucket.example.com/medialibrary/12/responsive-images/image___media_library_original_100_50.jpg')
        ->assertStatus(301);
});
