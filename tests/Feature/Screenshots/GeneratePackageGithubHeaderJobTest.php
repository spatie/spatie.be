<?php

use App\Jobs\GeneratePackageGithubHeaderJob;
use App\Models\Repository;
use Illuminate\Bus\UniqueLock;
use Illuminate\Cache\RateLimiting\Unlimited;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelScreenshot\Drivers\ScreenshotDriver;
use Spatie\LaravelScreenshot\ScreenshotOptions;

const TINY_PNG = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

beforeEach(function () {
    Storage::fake('medialibrary');

    $this->repository = Repository::factory()->createQuietly(['name' => 'laravel-permission']);
});

function fakeScreenshotDriver(): ScreenshotDriver
{
    $driver = new class () implements ScreenshotDriver {
        /** @var array<int, array{input: string, options: ScreenshotOptions}> */
        public array $screenshots = [];

        public function generateScreenshot(string $input, bool $isHtml, ScreenshotOptions $options): string
        {
            $this->screenshots[] = ['input' => $input, 'options' => $options];

            return base64_decode(TINY_PNG);
        }

        public function saveScreenshot(string $input, bool $isHtml, ScreenshotOptions $options, string $path): void
        {
            file_put_contents($path, $this->generateScreenshot($input, $isHtml, $options));
        }
    };

    app()->instance('laravel-screenshot.driver.fake', $driver);
    config()->set('laravel-screenshot.driver', 'fake');

    return $driver;
}

it('takes the header screenshots with the configured screenshot driver', function () {
    $driver = fakeScreenshotDriver();

    (new GeneratePackageGithubHeaderJob($this->repository))->handle();

    expect($driver->screenshots)->toHaveCount(2)
        ->and($driver->screenshots[0]['input'])->toBe(url('packages/header/laravel-permission/html/dark'))
        ->and($driver->screenshots[1]['input'])->toBe(url('packages/header/laravel-permission/html/light'));

    foreach ($driver->screenshots as $screenshot) {
        expect($screenshot['options'])
            ->width->toBe(830)
            ->height->toBe(190)
            ->deviceScaleFactor->toBe(2)
            ->omitBackground->toBeTrue()
            ->and($screenshot['options']->type->value)->toBe('png');
    }
});

it('stores the headers in the media library like before', function () {
    fakeScreenshotDriver();

    (new GeneratePackageGithubHeaderJob($this->repository))->handle();

    foreach (['dark', 'light'] as $mode) {
        $media = $this->repository->fresh()->getFirstMedia("github-header-{$mode}");

        expect($media)
            ->file_name->toBe('image.webp')
            ->mime_type->toBe('image/png')
            ->disk->toBe('medialibrary');

        Storage::disk('medialibrary')->assertExists($media->getPathRelativeToRoot());
    }
});

it('can render the headers with cloudflare browser rendering', function () {
    config()->set('laravel-screenshot.driver', 'cloudflare');
    config()->set('laravel-screenshot.cloudflare', ['api_token' => 'token', 'account_id' => 'account']);

    Http::fake([
        'api.cloudflare.com/*' => Http::response(base64_decode(TINY_PNG)),
    ]);

    (new GeneratePackageGithubHeaderJob($this->repository))->handle();

    Http::assertSentCount(2);
    Http::assertSent(fn ($request) => $request->url() === 'https://api.cloudflare.com/client/v4/accounts/account/browser-rendering/screenshot'
        && $request->hasHeader('Authorization', 'Bearer token')
        && $request['viewport'] === ['width' => 830, 'height' => 190, 'deviceScaleFactor' => 2]
        && $request['screenshotOptions'] === ['type' => 'png', 'omitBackground' => true]);

    expect($this->repository->fresh()->getFirstMedia('github-header-light'))->not->toBeNull();
});

it('only regenerates the header when something on it changed', function () {
    $repository = Repository::factory()->create();

    Queue::assertPushed(GeneratePackageGithubHeaderJob::class, 1);

    Cache::lock(UniqueLock::getKey(new GeneratePackageGithubHeaderJob($repository)))->forceRelease();

    $repository = $repository->fresh();
    $repository->update(['stars' => 12345, 'topics' => ['changed']]);
    $repository->save();

    Queue::assertPushed(GeneratePackageGithubHeaderJob::class, 1);

    $this->repository->update(['banner_title' => 'Laravel Permission']);

    Queue::assertPushed(GeneratePackageGithubHeaderJob::class, 2);
    Queue::assertPushed(GeneratePackageGithubHeaderJob::class, fn ($job) => $job->repository->is($this->repository));
});

it('dispatches one job per repository at a time', function () {
    $this->repository->update(['banner_title' => 'First']);
    $this->repository->update(['banner_title' => 'Second']);

    Queue::assertPushed(GeneratePackageGithubHeaderJob::class, 1);
});

it('throttles header generation only when using cloudflare', function () {
    $job = new GeneratePackageGithubHeaderJob($this->repository);

    expect($job->middleware())->toEqual([new RateLimited(GeneratePackageGithubHeaderJob::RATE_LIMITER)])
        ->and($job->retryUntil())->toBeGreaterThan(now()->addHours(23));

    $limiter = RateLimiter::limiter(GeneratePackageGithubHeaderJob::RATE_LIMITER);

    config()->set('laravel-screenshot.driver', 'browsershot');
    expect($limiter())->toBeInstanceOf(Unlimited::class);

    config()->set('laravel-screenshot.driver', 'cloudflare');
    expect($limiter())
        ->maxAttempts->toBe(1)
        ->decaySeconds->toBe(20);
});

it('can dispatch header generation for repositories without a header', function () {
    fakeScreenshotDriver();
    (new GeneratePackageGithubHeaderJob($this->repository))->handle();

    $withoutHeader = Repository::factory()->createQuietly(['name' => 'laravel-backup']);

    Artisan::call('app:generate-package-header', ['--missing' => true]);

    Queue::assertPushed(GeneratePackageGithubHeaderJob::class, 1);
    Queue::assertPushed(GeneratePackageGithubHeaderJob::class, fn ($job) => $job->repository->is($withoutHeader));
});

it('can dispatch header generation for specific repositories', function () {
    Artisan::call('app:generate-package-header', ['names' => ['laravel-permission']]);

    Queue::assertPushed(GeneratePackageGithubHeaderJob::class, fn ($job) => $job->repository->is($this->repository));
});
