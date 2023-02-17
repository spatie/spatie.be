<?php

namespace App\Http\Controllers;

use App\Services\Ray\Ray;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DownloadRayController
{
    public function __invoke(Request $request, Ray $ray, string $platform): RedirectResponse
    {
        abort_unless(in_array($platform, [
            'macosIntel',
            'macosAppleSilicon',
            'windows',
            'linux',
        ]), 404);

        return redirect()->to($ray->getDownloadLink($platform));
    }
}
