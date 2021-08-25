<?php

namespace App\Http\Api\Controllers;

use App\Domain\Shop\Models\License;

class ShowLicenseController
{
    public function __invoke(License $license)
    {
        return response()->json([
            'expires_at' => $license->expires_at?->timestamp,
        ]);
    }
}
