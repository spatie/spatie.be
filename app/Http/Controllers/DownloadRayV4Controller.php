<?php

namespace App\Http\Controllers;

use App\Services\Ray\RayV4;
use Illuminate\Http\RedirectResponse;

class DownloadRayV4Controller
{
    public function __invoke(RayV4 $ray, string $platform): RedirectResponse
    {
        abort_unless(in_array($platform, [
            'macos',
            'macos-arm64',
            'macos-x64',
            'windows',
            'linux',
        ]), 404);

        return redirect()->to($ray->getDownloadLink($platform));
    }
}
