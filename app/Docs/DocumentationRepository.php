<?php

namespace App\Docs;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;
use Spatie\Sheets\Factory;
use Spatie\Sheets\Repository;
use Spatie\Sheets\Sheet;

/**
 * Reads the sheets of a single docs repository from the current release on the docs disk.
 */
class DocumentationRepository implements Repository
{
    protected string $repositoryName;

    /** @param array<string, mixed> $config */
    public function __construct(
        protected Factory $factory,
        protected DocsStorage $storage,
        array $config = [],
    ) {
        $this->repositoryName = $config['repository_name'];
    }

    public function get(string $path): ?Sheet
    {
        $path = Str::finish($path, '.md');

        $releasePath = $this->storage->currentReleasePath($this->repositoryName);

        if (! $this->storage->disk()->exists("{$releasePath}/{$path}")) {
            return null;
        }

        return $this->make($releasePath, $path);
    }

    public function all(): Collection
    {
        $releasePath = $this->storage->currentReleasePath($this->repositoryName);

        $usesLegacyLayout = $releasePath === $this->repositoryName;

        return collect($this->storage->disk()->allFiles($releasePath))
            ->filter(fn (string $path) => str_ends_with($path, '.md'))
            ->map(fn (string $path) => Str::after($path, "{$releasePath}/"))
            ->reject(fn (string $path) => $usesLegacyLayout && str_starts_with($path, 'releases/'))
            ->map(fn (string $path) => $this->make($releasePath, $path))
            ->values();
    }

    /**
     * Every page remembers the release it was read from, so its contents can be
     * read later on without loading the other pages of the repository.
     */
    protected function make(string $releasePath, string $path): DocumentationPage
    {
        /** @var DocumentationPage $page */
        $page = $this->factory->make($path, $this->read("{$releasePath}/{$path}"));

        $page->releasePath = $releasePath;

        return $page;
    }

    /**
     * Throws instead of skipping a file, so an incomplete set of pages never gets cached.
     */
    protected function read(string $path): string
    {
        $contents = $this->storage->disk()->get($path);

        if ($contents === null) {
            throw new RuntimeException("Could not read docs file `{$path}`.");
        }

        return $contents;
    }
}
