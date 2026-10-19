<?php

use App\Jobs\GenerateOgImageJob;
use App\Jobs\GeneratePackageGithubHeaderJob;
use App\Jobs\Middleware\ThrottleScreenshots;
use App\Models\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelScreenshot\Exceptions\CouldNotTakeScreenshot;

beforeEach(function () {
    Storage::fake('public');
    Queue::fake([GenerateOgImageJob::class]);

    config()->set('laravel-screenshot.driver', 'cloudflare');
    config()->set('laravel-screenshot.cloudflare', ['api_token' => 'token', 'account_id' => 'account']);

    Http::preventStrayRequests();

    Cache::forever('og-image:abc123', ['url' => 'https://spatie.be/open-source']);
});

function cloudflareError(int $code, string $message): array
{
    return ['success' => false, 'errors' => [['code' => $code, 'message' => $message]]];
}

function runThrottled(object $job): void
{
    (new ThrottleScreenshots())->handle($job, fn ($job) => $job->handle());
}

it('serves an og image that was already generated', function () {
    Storage::disk('public')->put('og-images/abc123.jpeg', 'jpeg-bytes');

    $this->get('/og-image/abc123.jpeg')
        ->assertOk()
        ->assertHeader('Content-Type', 'image/jpeg');

    Queue::assertNothingPushed();
});

it('queues a missing og image and redirects to the default og image meanwhile', function () {
    $this->get('/og-image/abc123.jpeg')
        ->assertRedirect(url('images/og-image.jpg'))
        ->assertHeader('Cache-Control', 'no-store, private');

    Queue::assertPushed(GenerateOgImageJob::class, fn (GenerateOgImageJob $job) => $job->hash === 'abc123' && $job->format === 'jpeg');
    Http::assertNothingSent();
});

it('queues a missing og image only once', function () {
    $this->get('/og-image/abc123.jpeg');
    $this->get('/og-image/abc123.jpeg');

    Queue::assertPushed(GenerateOgImageJob::class, 1);
});

it('does not queue og images for unknown pages', function () {
    $this->get('/og-image/def456.jpeg')->assertNotFound();

    Queue::assertNothingPushed();
});

it('generates the og image on the queue', function () {
    Http::fake(['api.cloudflare.com/*' => Http::response('jpeg-bytes')]);

    (new GenerateOgImageJob('abc123', 'jpeg'))->handle();

    Http::assertSent(fn ($request) => $request['url'] === 'https://spatie.be/open-source?ogimage=');
    Storage::disk('public')->assertExists('og-images/abc123.jpeg');

    $this->get('/og-image/abc123.jpeg')->assertOk();
});

it('does not take a screenshot when the og image already exists', function () {
    Http::fake();
    Storage::disk('public')->put('og-images/abc123.jpeg', 'jpeg-bytes');

    (new GenerateOgImageJob('abc123', 'jpeg'))->handle();

    Http::assertNothingSent();
});

it('retries the og image later when cloudflare is rate limiting', function () {
    Http::fake(['api.cloudflare.com/*' => Http::response(cloudflareError(2001, 'Rate limit exceeded'), 429)]);

    $job = (new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions();

    runThrottled($job);

    $job->assertReleased(delay: 60)->assertNotFailed();
    Storage::disk('public')->assertMissing('og-images/abc123.jpeg');
});

it('retries the og image an hour later when the daily browser time is used up', function () {
    Http::fake(['api.cloudflare.com/*' => Http::response(cloudflareError(2001, 'Browser time limit exceeded for today'), 429)]);

    $job = (new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions();

    runThrottled($job);

    $job->assertReleased(delay: 60 * 60);
});

it('does not hide other screenshot errors', function () {
    Http::fake(['api.cloudflare.com/*' => Http::response(cloudflareError(10000, 'Authentication error'), 403)]);

    runThrottled((new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions());
})->throws(CouldNotTakeScreenshot::class, 'Authentication error');

it('shares one screenshot rate limiter between all screenshot jobs', function () {
    Http::fake(['api.cloudflare.com/*' => Http::response('png-bytes')]);
    Storage::fake('medialibrary');

    $repository = Repository::factory()->createQuietly(['name' => 'laravel-permission']);

    runThrottled((new GeneratePackageGithubHeaderJob($repository, 'dark'))->withFakeQueueInteractions());

    $ogImageJob = (new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions();

    runThrottled($ogImageJob);

    $ogImageJob->assertReleased();
    Http::assertSentCount(1);
});
