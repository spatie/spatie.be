<?php

namespace App\Docs;

use Illuminate\Support\Collection;

class Repository
{
    public string $slug;

    /** @var \App\Docs\Alias[] */
    public Collection $aliases;

    public function __construct(string $slug, Collection $aliases)
    {
        $this->slug = $slug;
        $this->aliases = $aliases;
    }

    public function getAlias(string $alias): ?Alias
    {
        return $this->aliases->firstWhere('slug', $alias);
    }
}
