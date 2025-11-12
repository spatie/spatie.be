<?php

namespace App\Providers;

use App\Support\Transformers\LdJsonTransformer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Spatie\LaravelUrlAiTransformer\Support\Transform;

class AiTransformerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Transform::urls('/', '/about-us')->usingTransformers(new LdJsonTransformer());
    }

    /**
     * @return array<int, string>
     */
    protected function crawlAllUrls(): array
    {
        $startUrl = url('/');

        $urls = [];

        Crawler::create()
            ->setCrawlObserver(new class ($urls) extends CrawlObserver {
                /** @param array<int, string> $urls  */
                public function __construct(protected array &$urls)
                {
                }

                public function crawled(
                    UriInterface $url,
                    ResponseInterface $response,
                    ?UriInterface $foundOnUrl = null,
                    ?string $linkText = null
                ): void {
                    $url = (string) $url;

                    if (Str::endsWith($url, '.svg')) {
                        return;
                    }

                    $this->urls[] = (string) $url;
                }
            })
            ->setCrawlProfile(new CrawlInternalUrls($startUrl))
            ->startCrawling($startUrl);

        return array_unique($urls);
    }




    //        Transform::urls(
    //            fn () => $this->crawlAllUrls()
    //        )->usingTransformers(new LdJsonTransformer());
}
