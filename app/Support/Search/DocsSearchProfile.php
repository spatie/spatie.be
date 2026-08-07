<?php

namespace App\Support\Search;

use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlResponse;
use Spatie\SiteSearch\Profiles\DefaultSearchProfile;

class DocsSearchProfile extends DefaultSearchProfile
{
    public function shouldIndex(string $url, CrawlResponse $response): bool
    {
        info('should index ' . $url);

        return true;
    }

    public function configureCrawler(Crawler $crawler): void
    {
        // Non-latest docs versions are served with a `noindex` robots meta tag for SEO.
        // Respecting it here would keep them out of our own docs search as well.
        $crawler->concurrency(5)->ignoreRobots();
    }
}
