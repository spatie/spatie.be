<?php

namespace App\Domain\Blog\Data;

class Author
{
    public function __construct(
        public string $name,
        public string $gravatar_url,
    ) {
    }
}
