<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

/**
 * When the media library lives in a bucket, old `/images/medialibrary/...` URLs
 * are redirected to the file in the bucket.
 */
class MediaLibraryFileController
{
    public function __invoke(string $path): RedirectResponse
    {
        abort_if(config('filesystems.disks.medialibrary.driver') === 'local', 404);

        return redirect(Storage::disk('medialibrary')->url($path), 301);
    }
}
