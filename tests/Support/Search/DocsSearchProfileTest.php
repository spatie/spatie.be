<?php

use App\Models\Repository;
use App\Support\Search\DocsSearchProfile;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlResponse;

it('does not respect robots, so that non-latest docs versions get indexed', function () {
    $crawler = Crawler::create('https://spatie.be/docs');

    (new DocsSearchProfile())->configureCrawler($crawler);

    expect($crawler->mustRespectRobots())->toBeFalse();
});

it('crawls with a recognizable user agent', function () {
    $crawler = Crawler::create('https://spatie.be/docs');

    (new DocsSearchProfile())->configureCrawler($crawler);

    expect($crawler->getUserAgent())->toBe('spatie.be site search crawler');
});

it('keeps staff docs out of the public search index without excluding public rust docs', function () {
    $profile = new DocsSearchProfile();
    foreach (['internal-example', 'internal-guide'] as $name) {
        Repository::factory()->create(['name' => $name, 'visibility' => 'staff']);
        $url = "https://spatie.be/docs/{$name}/v1/introduction";
        expect($profile->shouldCrawl($url))->toBeFalse();
        expect($profile->shouldIndex($url, CrawlResponse::fake('Confidential guide')))->toBeFalse();
    }

    $url = 'https://spatie.be/docs/rust-crawler/v1/introduction';
    expect($profile->shouldCrawl($url))->toBeTrue();
    expect($profile->shouldIndex($url, CrawlResponse::fake('Public guide')))->toBeTrue();
});
