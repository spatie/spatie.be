<?php

namespace App\Http\Api;

use App\Models\License;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SatisAuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:license-api');
    }

    public function __invoke(Authenticatable $license, Request $request)
    {
        /** @var $license \App\Models\License */
        if (! $license instanceof License) {
            abort(401);
        }

        $package = $this->getRequestedPackage($request);

        if (! $license->purchasable->includesPackageAccess($package)) {
            abort(401);
        }

        return response('valid');
    }

    private function getRequestedPackage(Request $request): string
    {
        $originalUrl = $request->header('X-Original-URI', '');

        preg_match('#^/dist/(?<package>spatie/[^/]*)/#', $originalUrl, $matches);

        if (! key_exists('package', $matches)) {
            abort(401, 'Missing X-Original-URI header');
        }

        return $matches['package'];
    }
}
