<?php

use App\Jobs\ImportDocsForRepositoryJob;
use App\Jobs\RandomizeAdsOnGitHubRepositoriesJob;
use App\Models\Repository;
use App\Support\Paddle\ProcessPaymentSucceededJob;
use App\Support\Search\CrawlSiteJob;
use Illuminate\Support\Facades\Queue;
use Spatie\MediaLibrary\Conversions\Jobs\PerformConversionsJob;
use Spatie\MediaLibrary\ResponsiveImages\Jobs\GenerateResponsiveImagesJob;
use Spatie\SiteSearch\Models\SiteSearchConfig;

beforeEach(function () {
    Queue::fake();
});

it('dispatches the site search crawl to the long running queue', function () {
    $siteSearchConfig = SiteSearchConfig::create([
        'name' => 'docs',
        'enabled' => true,
        'crawl_url' => 'https://spatie.be/docs',
        'index_base_name' => 'docs',
    ]);

    dispatch(new CrawlSiteJob($siteSearchConfig));

    Queue::assertPushedOn('long-running', CrawlSiteJob::class);
});

it('dispatches the github ads randomization to the long running queue', function () {
    dispatch(new RandomizeAdsOnGitHubRepositoriesJob());

    Queue::assertPushedOn('long-running', RandomizeAdsOnGitHubRepositoriesJob::class);
});

it('dispatches docs imports to the long running queue', function () {
    $repository = Repository::factory()->create(['name' => 'laravel-backup']);

    dispatch(new ImportDocsForRepositoryJob($repository->name));

    Queue::assertPushedOn('long-running', ImportDocsForRepositoryJob::class);
});

it('dispatches media library conversions to the long running queue', function () {
    expect(config('media-library.queue_name'))->toBeNull();

    $routes = app('queue.routes');

    expect($routes->all())
        ->toHaveKey(PerformConversionsJob::class, 'long-running')
        ->toHaveKey(GenerateResponsiveImagesJob::class, 'long-running');
});

it('keeps other jobs on the default queue', function () {
    expect(app('queue.routes')->all())->not->toHaveKey(ProcessPaymentSucceededJob::class);
});
