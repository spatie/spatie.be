<?php

namespace App\Http\Controllers;

use App\Services\Ray\RayV3;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DownloadRayV3Controller
{
    public function __invoke(Request $request, RayV3 $ray, string $platform): RedirectResponse
    {
        abort_unless(in_array($platform, [
            'macos-x64',
            'macos-arm64',
            'windows',
            'linux',
        ]), 404);

        return redirect()->to($ray->getDownloadLink($platform));
    }
}
