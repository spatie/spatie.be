<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\License;
use Illuminate\Routing\Controller;

class IsValidLicenseController extends Controller
{
    public function __invoke(string $license)
    {
        $license = License::where('key', $license)->firstOrFail();

        abort_if($license->isExpired(), 401);

        return 'OK';
    }
}
