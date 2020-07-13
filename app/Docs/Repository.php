<?php

namespace App\Docs;

class Repository
{
    public string $slug;

    public array $versions;

    public function __construct(string $slug, array $versions)
    {
        $this->slug = $slug;
        $this->versions = $versions;
    }
}
