<?php

namespace App\Jobs;

use DateTimeInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Http;

class PurgeGitHubAdImageCacheJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $repositoryName)
    {
    }

    /** @return array<int, object> */
    public function middleware(): array
    {
        return [new RateLimited('cloud-cache-purges')];
    }

    public function retryUntil(): DateTimeInterface
    {
        return now()->addDay();
    }

    /** @return array<int, int> */
    public function backoff(): array
    {
        return [10, 60, 300, 900];
    }

    public function handle(): void
    {
        $environmentId = config('services.laravel_cloud.environment_id');

        Http::withToken(config('services.laravel_cloud.cache_purge_token'))
            ->acceptJson()
            ->timeout(10)
            ->post("https://cloud.laravel.com/api/environments/{$environmentId}/purge-edge-cache", [
                'path' => route('githubAdImage', ['name' => $this->repositoryName], absolute: false),
            ])
            ->throw();
    }
}
