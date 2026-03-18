<?php

namespace App\Providers;

use App\Support\Transformers\LdJsonTransformer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Spatie\Crawler\CrawlProgress;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Spatie\Crawler\CrawlResponse;
use Spatie\LaravelUrlAiTransformer\Support\Transform;

class AiTransformerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //        Transform::urls(
        //            fn () => $this->crawlAllUrls()
        //        )->usingTransformers(new LdJsonTransformer());
    }

    /**
     * @return array<int, string>
     */
    protected function crawlAllUrls(): array
    {
        $startUrl = url('/');

        $urls = [];

        Crawler::create($startUrl)
            ->addObserver(new class ($urls) extends CrawlObserver {
                /** @param array<int, string> $urls  */
                public function __construct(protected array &$urls)
                {
                }

                public function crawled(
                    string $url,
                    CrawlResponse $response,
                    CrawlProgress $progress,
                ): void {
                    if (Str::endsWith($url, '.svg')) {
                        return;
                    }

                    $this->urls[] = $url;
                }
            })
            ->crawlProfile(new CrawlInternalUrls($startUrl))
            ->start();

        return array_unique($urls);
    }
}
