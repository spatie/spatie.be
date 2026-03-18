<?php

namespace App\Support\Search;

use Spatie\Crawler\CrawlResponse;
use Spatie\SiteSearch\Profiles\DefaultSearchProfile;

class DocsSearchProfile extends DefaultSearchProfile
{
    public function shouldIndex(string $url, CrawlResponse $response): bool
    {
        info('should index ' . $url);

        return true;
    }
}
