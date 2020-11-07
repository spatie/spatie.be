<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Routing\Controller;

class SignedLicenseController
{
    public function __invoke(string $license)
    {
        /** @var \App\Models\License $license */
        $license = License::where('key', $license)->firstOrFail();

        return response()->json($license);
    }
}
