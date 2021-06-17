<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AdminsOnly
{
    public function handle(Request $request, Closure $next)
    {
       /** @var User|null $user */
        $user = $request->user();

        if ($user?->is_admin) {
            return $next($request);
        }

        throw new AuthenticationException('Unauthenticated, user has no access to this area.');
    }
}
