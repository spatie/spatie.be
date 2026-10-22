<?php

namespace App\Actions;

use App\Jobs\PurgeGitHubAdImageCacheJob;
use App\Models\Repository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class SyncRepositoryAdImageToGitHubAdsDiskAction
{
    public FilesystemAdapter $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('github_ads');
    }

    public function execute(Repository $repository): void
    {
        $repository->hasAdWithImage()
            ? $this->updateAdForRepository($repository)
            : $this->removeAdForRepository($repository);

        if (config('services.laravel_cloud.cache_purge_token')) {
            PurgeGitHubAdImageCacheJob::dispatch($repository->name)->afterCommit();
        }
    }

    protected function updateAdForRepository(Repository $repository): void
    {
        $copied = $this->disk->copy(
            $repository->ad->image,
            $repository->gitHubAdImagePath(),
        );

        if (! $copied) {
            throw new RuntimeException("Could not update the ad for {$repository->name}.");
        }

        $legacyDisk = config('services.github_ads.legacy_disk');

        if (! $legacyDisk) {
            return;
        }

        $stream = $this->disk->readStream($repository->ad->image);

        if (! is_resource($stream)) {
            throw new RuntimeException("Could not read the ad for {$repository->name}.");
        }

        try {
            $copied = Storage::disk($legacyDisk)->put($repository->gitHubAdImagePath(), $stream, [
                'ContentType' => $this->disk->mimeType($repository->ad->image),
                'CacheControl' => 'max-age=120, s-maxage=120',
            ]);
        } finally {
            fclose($stream);
        }

        if (! $copied) {
            throw new RuntimeException("Could not update the legacy ad for {$repository->name}.");
        }
    }

    protected function removeAdForRepository(Repository $repository): void
    {
        if (! $this->disk->delete($repository->gitHubAdImagePath())) {
            throw new RuntimeException("Could not remove the ad for {$repository->name}.");
        }

        $legacyDisk = config('services.github_ads.legacy_disk');

        if (! $legacyDisk) {
            return;
        }

        if (! Storage::disk($legacyDisk)->delete($repository->gitHubAdImagePath())) {
            throw new RuntimeException("Could not remove the legacy ad for {$repository->name}.");
        }
    }
}
