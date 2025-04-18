<?php

namespace App\Docs;

use Illuminate\Support\Collection;

class Repository
{
    public string $slug;

    public Collection $aliases;

    public ?string $category;

    public function __construct(string $slug, Collection $aliases, ?DocumentationPage $index)
    {
        $this->slug = $slug;
        $this->aliases = $aliases;
        $this->category = $index->category ?? null;
    }

    public function getAlias(string $alias): ?Alias
    {
        return $this->aliases->firstWhere('slug', $alias);
    }
}
