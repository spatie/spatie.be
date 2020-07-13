<?php

namespace App\Docs;

use Illuminate\Support\Collection;
use Spatie\Sheets\Sheets;

class Docs
{
    private Collection $pages;

    public function __construct(Sheets $sheets)
    {
        $this->pages = $sheets->collection('docs')->all();
    }

    public function pages(): Collection
    {
        return $this->pages;
    }

    public function getRepositories(): Collection
    {
        return $this->pages
            ->map(fn (DocumentationPage $documentationPage) => $documentationPage->repository)
            ->values()
            ->unique()
            ->map(function (string $repository) {
                $versions = $this->pages
                    ->filter(fn (DocumentationPage $page) => $page->repository === $repository)
                    ->map(fn (DocumentationPage $page) => $page->alias)
                    ->values()
                    ->unique()
                    ->toArray();

                return new Repository($repository, $versions);
            });
    }

    public function getRepository(string $slug): Repository
    {
        return $this->getRepositories()->firstWhere('slug', $slug);
    }

    public function getVersions(string $repository): array
    {
        return $this->getRepository($repository)->versions;
    }
}
