<?php

namespace App\Http\Controllers;

use App\Models\Repository;

class PackageHeaderController
{
    public function html(string $name, $mode = 'dark')
    {
        \Debugbar::disable();

        $repository = Repository::where('name', $name)->firstOrFail();
        return view('front.pages.open-source.package-header', compact('repository', 'mode'));
    }

    public function image(string $name, $mode = 'dark')
    {
        $repository = Repository::where('name', $name)->firstOrFail();
        $media = $repository->getMedia('github-header-' . $mode)->first();

        if (! $media) {
            abort(404);
        }

        return response()->file($media->getPath());
    }
}
