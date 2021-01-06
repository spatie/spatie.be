<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProtectDocsOfUnreleasedPackages
{
    public function handle(Request $request, Closure $next)
    {
        info('in middleware');
        if (! Str::contains($request->url(), 'docs/ray')) {
            return $next($request);
        }
info('user?' . auth()->check() ? 'yes' : 'no');
        if (! $user = auth()->user()) {
            abort(403);
        }

        if (! $user->hasAccessToUnreleasedPurchasables()) {
            abort(403);
        }

        return $next($request);
    }
}
