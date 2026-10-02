<?php

namespace App\Docs;

use App\Exceptions\DocsImportException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class DocsImporter
{
    public function __construct(
        protected DocsStorage $storage,
        protected Docs $docs,
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
        Cache::lock("docs.import.{$repository['name']}", 60 * 15)
            ->block(60 * 5, fn () => $this->importRelease($repository));
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
        $archivePath = $this->downloadArchive($repository['repository'], $branch);

        if ($archivePath === null) {
            return 0;
        }

        $importedMarkdownFileCount = 0;

        try {
            foreach ((new DocsArchive($archivePath))->docsFiles() as $path => $contents) {
                if (! str_ends_with($path, '.md')) {
                    $this->storage->assetsDisk()->put("{$repository['name']}/{$alias}/{$path}", $contents);

                    continue;
                }

                $this->storage->disk()->put("{$releasePath}/{$alias}/{$path}", $contents);

                $importedMarkdownFileCount++;
            }
        } finally {
            @unlink($archivePath);
        }

        return $importedMarkdownFileCount;
    }

    /**
     * Streams the zipball of the branch to a temporary file. Returns null when the
     * branch doesn't exist, so the other branches of the repository still get imported.
     */
    protected function downloadArchive(string $repository, string $branch): ?string
    {
        $archivePath = tempnam(sys_get_temp_dir(), 'docs-archive-');

        $request = Http::accept('application/vnd.github+json')
            ->timeout(300)
            ->sink($archivePath);

        if ($token = $this->gitHubToken()) {
            $request->withToken($token);
        }

        try {
            $response = $request->get("https://api.github.com/repos/{$repository}/zipball/{$branch}");

            if ($response->notFound()) {
                Log::warning("Skipped importing docs of {$repository}@{$branch} because the branch was not found.");

                @unlink($archivePath);

                return null;
            }

            $response->throw();
        } catch (Throwable $exception) {
            @unlink($archivePath);

            throw $exception;
        }

        return $archivePath;
    }

    protected function gitHubToken(): ?string
    {
        return config('services.github.docs_access_token') ?: config('services.github.token');
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
