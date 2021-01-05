<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProtectDocsOfUnreleasedPackages
{
    public function handle(Request $request, Closure $next)
    {
        if (! Str::startsWith($request->url(), '/docs/ray')) {
            return $next($request);
        }

        if (! $user = auth()->user()) {
            abort(403);
        }

        if (! $user->hasAccessToUnreleasedPurchasables()) {
            abort(403);
        }

        return $next($request);
    }
}
