<?php

namespace App\Http\Api\Controllers;

use App\Domain\Shop\Models\License;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SatisAuthenticationController extends Controller
{
    public function __invoke(Authenticatable $license, Request $request)
    {
        /** @var $license \App\Domain\Shop\Models\License */
        if (! $license instanceof License) {
            abort(401);
        }

        /*
         * We have a master key that we use for our own projects that grants
         * use access to anything that is available on Satis.
         */
        if ($license->isMasterKey()) {
            return response('valid');
        }

        /*
         * Find the package that is actually being requested.
         */
        $package = $this->getRequestedPackage($request);

        /*
         * Composer can only store one authentication method per repository.
         * This means the user is probably gonna try to authenticate with a license
         * key for the wrong package. We have to check the user's other licenses
         * as well.
         */
        $hasAccess = License::query()
            ->whereNotExpired()
            ->whereHas('assignment', function (Builder $query) use ($license) {
                return $query->where('user_id', $license->assignment->user_id);
            })
            ->get()
            ->contains(
                fn (License $license) => $license->assignment->purchasable->includesPackageAccess($package)
            );

        abort_unless($hasAccess, 401);

        return response('valid');
    }

    private function getRequestedPackage(Request $request): string
    {
        $originalUrl = $request->header('X-Original-URI', '');

        // For example: /dist/spatie/laravel-mailcoach/spatie-laravel-mailcoach-xxx-zip-xx.zip
        preg_match('#^/dist/(?<package>spatie/[^/]*)/#', $originalUrl, $matches);

        if (! key_exists('package', $matches)) {
            abort(401, 'Missing X-Original-URI header');
        }

        return $matches['package'];
    }
}
