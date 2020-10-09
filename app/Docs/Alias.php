<?php

namespace App\Docs;

use Illuminate\Support\Collection;

class Alias
{
    public string $slug;

    public string $slogan;

    public string $branch;

    public string $githubUrl;

    public Collection $pages;

    public function __construct(
        string $slug,
        string $slogan,
        string $branch,
        string $githubUrl,
        Collection $pages
    ) {
        $this->slug = $slug;
        $this->slogan = $slogan;
        $this->branch = $branch;
        $this->githubUrl = $githubUrl;
        $this->pages = $pages;
    }
}
