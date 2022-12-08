<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsValidPlainRequest
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('plain-secret') === config('services.plain.secret')) {
            return $next($request);
        }

        abort(Response::HTTP_FORBIDDEN, 'Invalid Plain request');
    }
}
