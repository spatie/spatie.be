<?php

namespace App\Support\Search;

use Spatie\SiteSearch\Jobs\CrawlSiteJob as BaseCrawlSiteJob;

class CrawlSiteJob extends BaseCrawlSiteJob
{
    public $timeout = 60 * 20;
}
