<?php

namespace App\Docs;

use App\Exceptions\DocsImportException;
use Generator;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

/**
 * Downloads the files in the `docs` folder of a repository through the GitHub API.
 *
 * Archives (zipballs and tarballs) can't be used, because most of our packages
 * mark the `docs` folder as `export-ignore` in their `.gitattributes`.
 */
class GitHubDocsDownloader
{
    protected int $concurrentDownloads = 10;

    public function latestCommit(string $repository, string $branch): ?string
    {
        $response = $this->request()
            ->retry(3, 1000, $this->isTransientFailure(...), throw: false)
            ->get("https://api.github.com/repos/{$repository}/branches/{$branch}");

        if ($response->notFound()) {
            return null;
        }

        return $response->throw()->json('commit.sha');
    }

    /**
     * Yields the contents of every file in the `docs` folder at the given commit,
     * keyed by its path relative to that folder.
     *
     * @return Generator<string, string>
     */
    public function docsFiles(string $repository, string $commit): Generator
    {
        $paths = $this->docsPaths($repository, $commit);

        foreach ($paths->chunk($this->concurrentDownloads) as $chunkOfPaths) {
            $responses = Http::pool(fn (Pool $pool) => $chunkOfPaths
                ->map(fn (string $path) => $this->request($pool->as($path))->get($this->rawUrl($repository, $commit, $path)))
                ->all());

            foreach ($chunkOfPaths as $path) {
                yield $path => $this->contents($repository, $commit, $path, $responses[$path]);
            }
        }
    }

    /** @return Collection<int, string> */
    protected function docsPaths(string $repository, string $commit): Collection
    {
        $response = $this->request()
            ->retry(3, 1000, $this->isTransientFailure(...))
            ->get("https://api.github.com/repos/{$repository}/git/trees/{$commit}", ['recursive' => 1]);

        if ($response->json('truncated')) {
            throw new DocsImportException("The file tree of {$repository} at {$commit} is too large to be fetched at once.");
        }

        return collect($response->json('tree'))
            ->filter(fn (array $entry) => $entry['type'] === 'blob')
            ->reject(fn (array $entry) => $entry['mode'] === '120000')
            ->pluck('path')
            ->filter(fn (string $path) => str_starts_with($path, 'docs/'))
            ->map(fn (string $path) => Str::after($path, 'docs/'))
            ->filter(fn (string $path) => $this->isSafePath($path))
            ->values();
    }

    protected function contents(string $repository, string $commit, string $path, Response|Throwable $response): string
    {
        if ($response instanceof Throwable || $response->failed()) {
            $response = $this->request()
                ->retry(3, 1000, $this->isTransientFailure(...), throw: false)
                ->get($this->rawUrl($repository, $commit, $path));
        }

        if ($response->failed()) {
            throw new DocsImportException("Could not download docs file `{$path}` (status {$response->status()}).");
        }

        return $response->body();
    }

    protected function rawUrl(string $repository, string $commit, string $path): string
    {
        $encodedPath = collect(explode('/', "docs/{$path}"))
            ->map(rawurlencode(...))
            ->implode('/');

        return "https://raw.githubusercontent.com/{$repository}/{$commit}/{$encodedPath}";
    }

    protected function isTransientFailure(Throwable $exception): bool
    {
        if (! $exception instanceof RequestException) {
            return true;
        }

        return $exception->response->serverError() || $exception->response->tooManyRequests();
    }

    protected function isSafePath(string $path): bool
    {
        if ($path === '') {
            return false;
        }

        return ! in_array('..', explode('/', $path), true);
    }

    protected function request(?PendingRequest $request = null): PendingRequest
    {
        $request ??= Http::createPendingRequest();

        $request->timeout(60);

        if ($token = $this->gitHubToken()) {
            $request->withToken($token);
        }

        return $request;
    }

    protected function gitHubToken(): ?string
    {
        return config('services.github.docs_access_token') ?: config('services.github.token');
    }
}
