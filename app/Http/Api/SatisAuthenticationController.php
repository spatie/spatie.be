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

        if ($license->isMasterKey()) {
            return response('valid');
        }

        $package = $this->getRequestedPackage($request);

        /*
         * Composer can only store one authentication method per repository.
         * This means the user is probably gonna try to authenticate with a license
         * key for the wrong package. We have to check the user's other licenses
         * as well.
         */
        $hasAccess = License::query()
            ->with(['purchasable'])
            ->whereNotExpired()
            ->where('user_id', $license->user_id)
            ->get()
            ->contains(
                fn (License $license) => $license->purchasable->includesPackageAccess($package)
            );

        abort_unless($hasAccess, 401);

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
