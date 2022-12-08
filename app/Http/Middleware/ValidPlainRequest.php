<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ValidPlainRequest
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->header('plain-secret') === config('services.plain.secret')) {
            abort(Response::HTTP_FORBIDDEN, 'Invalid Plain request');
        }

        return $next($request);
    }
}
