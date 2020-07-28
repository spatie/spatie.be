<?php

namespace App\Docs;

use Illuminate\Support\Collection;

class Alias
{
    public string $slug;

    public string $slogan;

    public string $branch;

    /** @var \App\Docs\DocumentationPage[] */
    public Collection $pages;

    public function __construct(string $slug, string $slogan, string $branch, Collection $pages)
    {
        $this->slug = $slug;
        $this->slogan = $slogan;
        $this->branch = $branch;
        $this->pages = $pages;
    }
}
