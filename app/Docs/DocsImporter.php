<?php

namespace App\Docs;

use App\Exceptions\DocsImportException;
use Illuminate\Contracts\Cache\Lock;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class DocsImporter
{
    public const int LOCK_SECONDS = 60 * 15;

    public function __construct(
        protected DocsStorage $storage,
        protected Docs $docs,
        protected GitHubDocsDownloader $gitHubDocsDownloader,
    ) {
    }

    /**
     * Assets are written in place first, then the markdown is written to a new release
     * that only gets activated once every branch was imported. Imports of the same
     * repository never run at the same time, as they would prune each other's release.
     *
     * @param array{
     *     name: string,
     *     repository: string,
     *     branches: array<string, string>,
     *     category: string
     * } $repository
     */
    public function import(array $repository): void
    {
        $this->lock($repository)->block(60 * 5, fn () => $this->importRelease($repository));
    }

    /**
     * Returns false without importing when another import of the repository holds the lock.
     *
     * @param array{
     *     name: string,
     *     repository: string,
     *     branches: array<string, string>,
     *     category: string
     * } $repository
     */
    public function importUnlessAlreadyImporting(array $repository): bool
    {
        $lock = $this->lock($repository);

        if (! $lock->get()) {
            return false;
        }

        try {
            $this->importRelease($repository);
        } finally {
            $lock->release();
        }

        return true;
    }

    /**
     * @param array{
     *     name: string,
     *     repository: string,
     *     branches: array<string, string>,
     *     category: string
     * } $repository
     */
    protected function lock(array $repository): Lock
    {
        return Cache::lock("docs.import.{$repository['name']}", self::LOCK_SECONDS);
    }

    /**
     * @param array{
     *     name: string,
     *     repository: string,
     *     branches: array<string, string>,
     *     category: string
     * } $repository
     */
    protected function importRelease(array $repository): void
    {
        $releasePath = $this->storage->createReleasePath($repository['name']);

        try {
            $this->storage->disk()->put("{$releasePath}/_index.md", $this->repositoryIndex($repository));

            $importedMarkdownFileCount = 0;

            foreach ($repository['branches'] as $branch => $alias) {
                $importedMarkdownFileCount += $this->importBranch($repository, (string) $branch, $alias, $releasePath);
            }

            if ($importedMarkdownFileCount === 0) {
                throw new DocsImportException("No docs were found for {$repository['repository']}, keeping the current docs.");
            }
        } catch (Throwable $exception) {
            $this->storage->deleteRelease($releasePath);

            throw $exception;
        }

        $previousReleasePath = $this->storage->currentReleasePath($repository['name']);

        $this->storage->activateRelease($repository['name'], $releasePath);

        $this->docs->refreshRepository($repository['name']);

        $this->storage->pruneReleases($repository['name'], $previousReleasePath);
    }

    /**
     * @param array{
     *     name: string,
     *     repository: string,
     *     branches: array<string, string>,
     *     category: string
     * } $repository
     * @param string $branch
     * @param string $alias
     * @param string $releasePath
     *
     * @return int The number of imported markdown files.
     */
    protected function importBranch(array $repository, string $branch, string $alias, string $releasePath): int
    {
        $commit = $this->gitHubDocsDownloader->latestCommit($repository['repository'], $branch);

        if ($commit === null) {
            Log::warning("Skipped importing docs of {$repository['repository']}@{$branch} because the branch was not found.");

            return 0;
        }

        $importedMarkdownFileCount = 0;

        foreach ($this->gitHubDocsDownloader->docsFiles($repository['repository'], $commit) as $path => $contents) {
            if (! str_ends_with($path, '.md')) {
                $this->storage->assetsDisk()->put("{$repository['name']}/{$alias}/{$path}", $contents);

                continue;
            }

            $this->storage->disk()->put("{$releasePath}/{$alias}/{$path}", $contents);

            $importedMarkdownFileCount++;
        }

        return $importedMarkdownFileCount;
    }

    /**
     * @param array{
     *     name: string,
     *     category: string
     * } $repository
     */
    protected function repositoryIndex(array $repository): string
    {
        return "---\ntitle: {$repository['name']}\ncategory: {$repository['category']}\n---\n";
    }
}
