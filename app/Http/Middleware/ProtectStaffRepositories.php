<?php

namespace App\Http\Middleware;

use App\Support\RepositoryAccess;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Symfony\Component\HttpFoundation\Response;

class ProtectStaffRepositories
{
    public function handle(Request $request, Closure $next): Response
    {
        if (RepositoryAccess::isRestrictedUrl($request->url())) {
            // Public assets remain sessionless; private assets need the staff session.
            if (! $request->hasSession()) {
                return app(StartSession::class)->handle($request, fn (Request $request) => $this->authorize($request, $next));
            }

            return $this->authorize($request, $next);
        }

        $response = $next($request);

        if ($request->is('docs', 'open-source/packages') || RepositoryAccess::canViewRestricted()) {
            $response->headers->set('Cache-Control', 'private, no-store');
            $response->setVary('Cookie', false);
        }

        return $response;
    }

    protected function authorize(Request $request, Closure $next): Response
    {
        abort_unless(RepositoryAccess::canViewRestricted(), 404, headers: ['Cache-Control' => 'private, no-store']);
        abort_if($request->has(config('og-image.preview_parameter')), 404, headers: ['Cache-Control' => 'private, no-store']);

        $response = $next($request);
        $response->headers->set('Cache-Control', 'private, no-store');
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
        $response->headers->set('Site-Search-Do-Not-Index', '1');
        $response->setVary('Cookie', false);

        return $response;
    }
}
