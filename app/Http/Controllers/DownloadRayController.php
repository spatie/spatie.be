<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Services\Ray\Ray;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadRayController
{
    public function __invoke(Request $request, Ray $ray, string $platform)
    {
        abort_unless(in_array($platform, [
            'macos',
            'windows',
            'linux',
        ]), 404);

        return redirect()->to($ray->getDownloadLink($platform));
    }
}
