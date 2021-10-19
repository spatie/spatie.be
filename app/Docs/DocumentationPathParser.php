<?php

namespace App\Docs;

use Illuminate\Support\Str;
use Spatie\Sheets\PathParser;

class DocumentationPathParser implements PathParser
{
    public function parse(string $path): array
    {
        $parts = explode('/', $path);

        $alias = $parts[0];

        if (count($parts) <= 1) {
            $slug = Str::before($alias, '.md');

            return [
                'slug' => $slug,
                'alias' => null,
            ];
        }

        $slug = Str::before(implode('/', array_slice($parts, 1)), '.md');

        return [
            'slug' => $slug,
            'alias' => $alias,
        ];
    }
}
