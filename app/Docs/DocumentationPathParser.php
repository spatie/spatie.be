<?php

namespace App\Docs;

use Illuminate\Support\Str;
use Spatie\Sheets\PathParser;

class DocumentationPathParser implements PathParser
{
    public function parse(string $path): array
    {
        $parts = explode('/', $path);

        $repository = $parts[0];

        $alias = $parts[1];

        if (count($parts) <= 2) {
            $slug = Str::before($alias, '.md');

            return [
                'slug' => $slug,
                'repository' => $repository,
                'alias' => null,
            ];
        }

        $slug = Str::before(implode('/', array_slice($parts, 2)), '.md');

        return [
            'slug' => $slug,
            'repository' => $repository,
            'alias' => $alias,
        ];
    }
}
