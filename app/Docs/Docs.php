<?php

namespace App\Docs;

use Exception;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Spatie\Sheets\Sheets;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Throwable;

class Docs
{
    public function __construct(
        protected DocsStorage $storage,
    ) {
    }

    public function getRepository(string $slug): ?Repository
    {
        $pages = $this->pages($slug);

        $aliases = $pages
            ->whereNotNull('alias')
            ->groupBy(fn (DocumentationPage $page) => $page->alias)
            ->map(function (Collection $pages) use ($slug) {
                $index = $pages->firstWhere('slug', '_index');
                $pages = $pages
                    ->where('slug', '<>', '_index')
                    ->sortBy(fn (DocumentationPage $page): int => $page->weight ?? PHP_INT_MAX)
                    ->map(function (DocumentationPage $page) use ($slug) {
                        $page->repository = $slug;

                        return $page;
                    });

                if (! $index) {
                    return null;
                }

                try {
                    return Alias::fromDocumentationPage($index, $pages);
                } catch (Throwable $e) {
                    info($index);

                    throw $e;
                }
            })
            ->filter()
            ->sortBy('versionNumber', SORT_NATURAL, true);

        $index = $pages
            ->whereNull('alias')
            ->firstWhere('slug', '_index');

        return new Repository($slug, $aliases, $index);
    }

    /**
     * The cached pages of a repository don't contain their markdown, so a request only
     * reads the markdown of the page it shows.
     */
    public function pageContents(DocumentationPage $page): string
    {
        $path = "{$page->releasePath}/{$page->getPath()}";

        $markdown = $this->storage->disk()->get($path);

        if ($markdown === null) {
            throw new RuntimeException("Could not read docs file `{$path}`.");
        }

        return YamlFrontMatter::parse($markdown)->body();
    }

    public function refreshRepository(string $slug): void
    {
        $this->cache()->forever($this->cacheKey($slug), $this->loadPages($slug));
    }

    /**
     * A request that started reading the previous release before an import finished
     * uses `add`, so it can't overwrite the pages that the import just cached.
     */
    protected function pages(string $slug): Collection
    {
        $cachedPages = $this->cache()->get($this->cacheKey($slug));

        if ($cachedPages !== null) {
            return $cachedPages;
        }

        $pages = $this->loadPages($slug);

        $this->cache()->add($this->cacheKey($slug), $pages);

        return $pages;
    }

    protected function loadPages(string $slug): Collection
    {
        return app(Sheets::class)
            ->collection($slug)
            ->all()
            ->each(fn (DocumentationPage $page) => $page->offsetUnset('contents'))
            ->sortBy('weight');
    }

    protected function cache(): CacheRepository
    {
        return Cache::store(config('docs.cache_store'));
    }

    protected function cacheKey(string $slug): string
    {
        return "docs.pages.{$slug}";
    }

    public function getRepositories(): Collection
    {
        return collect(config('docs.repositories'))
            ->pluck('name')
            ->map(function (string $repositoryName) {
                try {
                    return $this->getRepository($repositoryName);
                } catch (Exception $e) {
                    report("Error while loading {$repositoryName} docs: " . $e->getMessage());

                    return null;
                }
            })->filter();
    }
}
