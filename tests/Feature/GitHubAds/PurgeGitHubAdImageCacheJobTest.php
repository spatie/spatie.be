<?php

use App\Jobs\PurgeGitHubAdImageCacheJob;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config()->set('services.laravel_cloud', [
        'environment_id' => 'env-production',
        'cache_purge_token' => 'purge-token',
    ]);
});

it('purges only the repository image using the configured credentials', function () {
    Http::fake(['cloud.laravel.com/*' => Http::response([], 200)]);

    (new PurgeGitHubAdImageCacheJob('spatie.be'))->handle();

    Http::assertSent(fn (Request $request) => $request->url() === 'https://cloud.laravel.com/api/environments/env-production/purge-edge-cache'
        && $request->hasHeader('Authorization', 'Bearer purge-token')
        && $request->data() === ['path' => '/github-ad-image/spatie.be.jpg']);
});

it('fails on an unsuccessful purge so the queue can retry', function () {
    Http::fake(['cloud.laravel.com/*' => Http::response([], 429)]);

    expect(fn () => (new PurgeGitHubAdImageCacheJob('laravel-permission'))->handle())
        ->toThrow(RequestException::class);
});
