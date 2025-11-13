<?php

namespace App\Services\Crawler;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\Crawler as SpatieCrawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;

class Crawler
{
    public static function getAllUrls(): array
    {
        $startUrl = url('/');

        $urls = [];

        SpatieCrawler::create([
            RequestOptions::VERIFY => false,
        ])
            ->setCrawlObserver(new class ($urls) extends CrawlObserver {
                /** @param array<int, string> $urls */
                public function __construct(protected array &$urls)
                {
                }

                public function crawled(
                    UriInterface $url,
                    ResponseInterface $response,
                    ?UriInterface $foundOnUrl = null,
                    ?string $linkText = null
                ): void {
                    $url = (string)$url;

                    if (Str::endsWith($url, '.svg')) {
                        return;
                    }

                    $this->urls[] = (string)$url;
                }
            })
            ->setCrawlProfile(new CrawlInternalUrls($startUrl))
            ->startCrawling($startUrl);

        return collect($urls)
            ->map(fn (string $url) => Str::after($url, config('app.url')))
            ->unique()
            ->toArray();
    }
}
