<?php

namespace App\Docs;

use Illuminate\Support\Collection;

class Alias
{
    public function __construct(
        public string $slug,
        public string $slogan,
        public string $branch,
        public string $githubUrl,
        public Collection $pages
    ) {
    }
}
