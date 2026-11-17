<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\MarkdownResponse\Middleware\ProvideMarkdownResponse;
use Symfony\Component\HttpFoundation\Response;

class ProvideHomepageMarkdownResponse extends ProvideMarkdownResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = parent::handle($request, $next);

        $response->headers->set('Link', '<'.url('/llms.txt').'>; rel="describedby"; type="text/plain"', false);
        $response->setVary(array_unique([...$response->getVary(), 'Accept', 'User-Agent']));

        return $response;
    }

    protected function buildContentSignalHeader(): string
    {
        return '';
    }
}
