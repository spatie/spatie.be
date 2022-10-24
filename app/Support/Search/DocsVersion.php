<?php

namespace App\Support\Search;

use Illuminate\Support\Str;
use Psr\Http\Message\UriInterface;
use Spatie\Url\Url;

class DocsVersion
{
    public static function getVersion(UriInterface|string $uri): string
    {
        if (is_string($uri)) {
            $uri = Url::fromString($uri);
        }

        $path = $uri->getPath();

        return explode('/', $path)[3] ?? '';
    }

    public static function getRepo(UriInterface|string $uri): string
    {
        if (is_string($uri)) {
            $uri = Url::fromString($uri);
        }

        $path = $uri->getPath();

        return explode('/', $path)[2] ?? '';
    }
}
