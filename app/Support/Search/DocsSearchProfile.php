<?php

namespace App\Support\Search;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\SiteSearch\Profiles\DefaultSearchProfile;

class DocsSearchProfile extends DefaultSearchProfile
{
    public function shouldIndex(UriInterface $url, ResponseInterface $response): bool
    {
        info('should index ' . $url);

        return true;
    }
}
