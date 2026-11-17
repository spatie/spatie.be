<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProvideMarkdownLinks
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('markdown-response.enabled', true)) {
            return $response;
        }

        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        if (! str_starts_with($response->headers->get('Content-Type', ''), 'text/html')) {
            return $response;
        }

        $url = $request->url();

        if (config('markdown-response.detection.detect_via_md_suffix', true)) {
            $url .= '.md';
        }

        $response->headers->set('Link', '<'.$url.'>; rel="alternate"; type="text/markdown"', false);

        return $response;
    }
}
