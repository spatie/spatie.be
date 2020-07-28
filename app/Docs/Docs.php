<?php

namespace App\Docs;

use Illuminate\Support\Collection;
use Spatie\Sheets\Sheets;

class Docs
{
    private Collection $pages;

    public function __construct(Sheets $sheets)
    {
        $this->pages = $sheets->collection('docs')->all()->sortBy('weight');
    }

    public function pages(): Collection
    {
        return $this->pages;
    }

    public function getRepository(string $slug): Repository
    {
        return $this->getRepositories()->firstWhere('slug', $slug);
    }

    public function getRepositories(): Collection
    {
        return $this->pages
            ->pluck('repository')
            ->unique()
            ->map(function (string $repository) {
                $aliases = $this->pages
                    ->where('repository', $repository)
                    ->whereNotNull('alias')
                    ->groupBy(fn (DocumentationPage $page) => $page->alias)
                    ->map(function (Collection $pages, string $alias) {
                        $index = $pages->firstWhere('slug', '_index');
                        $pages = $pages->where('slug', '<>', '_index');

                        return new Alias($index->title, $index->slogan, $index->branch, $pages);
                    })
                    ->sortBy('slug');

                return new Repository($repository, $aliases);
            });
    }
}
