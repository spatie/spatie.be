<?php

namespace App\Http\Middleware;

use Closure;

class OnlyForSpatie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->check()) {
            return abort(401);
        }

        if (! auth()->user()->isSpatieMember()) {
            abort(401);
        }

        return $next($request);
    }
}
