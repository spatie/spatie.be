<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        Auth::shouldUse('web');

        if (! Auth::user()?->canAccessPanel(Filament::getPanel('admin'))) {
            abort_if($request->expectsJson(), 403);

            return redirect()->route('filament.admin.auth.login');
        }

        return $next($request);
    }
}
