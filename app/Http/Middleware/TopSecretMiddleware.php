<?php

namespace App\Http\Middleware;

use Carbon\CarbonImmutable;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TopSecretMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (CarbonImmutable::now()->isAfter(CarbonImmutable::create(2024, 11, 25, 9, 0, 0))) {
            return $next($request);
        }

        if (str_ends_with(Auth::user()?->email, '@spatie.be')) {
            return $next($request);
        }

        return redirect()->to('soon');
    }
}
