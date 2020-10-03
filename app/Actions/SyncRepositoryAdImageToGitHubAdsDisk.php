<?php

namespace App\Actions;

use App\Models\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class SyncRepositoryAdImageToGitHubAdsDisk
{
    public Filesystem $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('github_ads');
    }

    public function execute(Repository $repository): void
    {
        $repository->hasAdWithImage()
            ? $this->updateAdForRepository($repository)
            : $this->removeAdForRepository($repository);
    }

    protected function updateAdForRepository(Repository $repository): void
    {
        $this->disk->delete($repository->gitHubAdImagePath());

        $this->disk->copy(
            $repository->ad->image,
            $repository->gitHubAdImagePath(),
        );
    }

    protected function removeAdForRepository(Repository $repository): void
    {
        $this->disk->delete($repository->gitHubAdImagePath());
    }
}