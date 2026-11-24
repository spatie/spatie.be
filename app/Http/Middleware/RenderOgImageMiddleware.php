<?php

namespace App\Http\Middleware;

use Spatie\OgImage\Http\Middleware\RenderOgImageMiddleware as BaseRenderOgImageMiddleware;
use Symfony\Component\HttpFoundation\Response;

class RenderOgImageMiddleware extends BaseRenderOgImageMiddleware
{
    protected function shouldSkip(Response $response): bool
    {
        return parent::shouldSkip($response)
            || ! str_contains($response->headers->get('Content-Type', ''), 'text/html');
    }
}
