<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Nova\Contracts\ImpersonatesUsers;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AddImpersonateOverlay
{
    public function __construct(protected ImpersonatesUsers $impersonator)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldAddOverlay($request, $response)) {
            $this->addDialogToResponse($response);
        }

        return $response;
    }

    protected function shouldAddOverlay(Request $request, $response): bool
    {
        if (! $this->impersonator->impersonating($request)) {
            return false;
        }

        if ($response instanceof RedirectResponse) {
            return false;
        }

        if ($response instanceof BinaryFileResponse) {
            return false;
        }

        if ($response instanceof StreamedResponse) {
            return false;
        }

        if ($response instanceof JsonResponse) {
            return false;
        }

        if ($request->expectsJson()) {
            return false;
        }

        if (Str::contains($request->path(), 'nova-api')) {
            return false;
        }

        return true;
    }

    protected function addDialogToResponse(Response $response)
    {
        $content = $response->getContent();

        $content .= view('impersonate.overlay', [
            'impersonatingAsUser' => auth()->user(),
        ]);

        $response->setContent($content);
    }
}
