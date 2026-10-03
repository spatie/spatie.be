<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Debugbar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PackageHeaderController
{
    public function html(string $name, $mode = 'dark')
    {
        Debugbar::disable();

        $repository = Repository::where('name', $name)->firstOrFail();

        return view('front.pages.open-source.package-header', compact('repository', 'mode'));
    }

    public function image(string $name, $mode = 'dark'): StreamedResponse|RedirectResponse
    {
        $repository = Repository::where('name', $name)->firstOrFail();
        $media = $repository->getMedia('github-header-' . $mode)->first();

        if (! $media) {
            abort(404);
        }

        /*
         * A regenerated header gets a new url in the bucket, so the redirect is temporary.
         */
        if (config("filesystems.disks.{$media->disk}.driver") !== 'local') {
            return redirect()->away($media->getUrl(), 302, [
                'Cache-Control' => 'public, max-age=3600',
            ]);
        }

        /*
         * The header is a PNG stored as image.webp, see GeneratePackageGithubHeaderJob.
         */
        return Storage::disk($media->disk)->response($media->getPathRelativeToRoot(), headers: [
            'Content-Type' => 'image/png',
        ]);
    }
}
