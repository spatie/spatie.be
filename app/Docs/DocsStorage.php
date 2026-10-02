<?php

namespace App\Docs;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Markdown of a repository lives in `{repository}/releases/{release}` on the docs disk.
 * The `{repository}/current-release` file points to the release that is being served,
 * so a new import only becomes visible once it has been written completely.
 *
 * Repositories imported before releases existed keep their markdown directly in
 * `{repository}`. That legacy layout is read until the repository is imported again.
 */
class DocsStorage
{
    public function disk(): Filesystem
    {
        return Storage::disk(config('docs.disk'));
    }

    public function assetsDisk(): Filesystem
    {
        return Storage::disk(config('docs.assets_disk'));
    }

    public function createReleasePath(string $repositoryName): string
    {
        $release = Str::lower((string) Str::ulid());

        return "{$repositoryName}/releases/{$release}";
    }

    public function currentReleasePath(string $repositoryName): string
    {
        $pointerPath = $this->pointerPath($repositoryName);

        if (! $this->disk()->exists($pointerPath)) {
            return $repositoryName;
        }

        $release = trim((string) $this->disk()->get($pointerPath));

        if ($release === '') {
            return $repositoryName;
        }

        return "{$repositoryName}/releases/{$release}";
    }

    public function usesLegacyLayout(string $repositoryName): bool
    {
        return $this->currentReleasePath($repositoryName) === $repositoryName;
    }

    public function activateRelease(string $repositoryName, string $releasePath): void
    {
        $pointerPath = $this->pointerPath($repositoryName);

        $temporaryPointerPath = "{$pointerPath}-" . Str::random(8);

        $this->disk()->put($temporaryPointerPath, Str::afterLast($releasePath, '/'));

        $this->disk()->move($temporaryPointerPath, $pointerPath);
    }

    /**
     * Keeps the current and the previous release, so a request that started
     * reading the previous release just before the switch can still finish.
     */
    public function pruneReleases(string $repositoryName, string $previousReleasePath): void
    {
        $releasePathsToKeep = [
            $this->currentReleasePath($repositoryName),
            $previousReleasePath,
        ];

        collect($this->disk()->directories("{$repositoryName}/releases"))
            ->reject(fn (string $releasePath) => in_array($releasePath, $releasePathsToKeep))
            ->each(fn (string $releasePath) => $this->disk()->deleteDirectory($releasePath));

        if (! in_array($repositoryName, $releasePathsToKeep)) {
            $this->deleteLegacyLayout($repositoryName);
        }
    }

    public function deleteRelease(string $releasePath): void
    {
        $this->disk()->deleteDirectory($releasePath);
    }

    protected function deleteLegacyLayout(string $repositoryName): void
    {
        collect($this->disk()->directories($repositoryName))
            ->reject(fn (string $directory) => $directory === "{$repositoryName}/releases")
            ->each(fn (string $directory) => $this->disk()->deleteDirectory($directory));

        collect($this->disk()->files($repositoryName))
            ->reject(fn (string $file) => $file === $this->pointerPath($repositoryName))
            ->each(fn (string $file) => $this->disk()->delete($file));
    }

    protected function pointerPath(string $repositoryName): string
    {
        return "{$repositoryName}/current-release";
    }
}
