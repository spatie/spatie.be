<?php

use App\Support\Search\DocsSearchProfile;
use Spatie\Crawler\Crawler;

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
