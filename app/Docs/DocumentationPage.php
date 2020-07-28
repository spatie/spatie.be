<?php

namespace App\Docs;

use App\Http\Front\Controllers\DocsController;
use Github\Api\Repo;
use Illuminate\Support\Str;
use PhpParser\Comment\Doc;
use Spatie\Sheets\Sheet;
use Spatie\Sheets\Sheets;

class DocumentationPage extends Sheet
{
    public function isIndex(): bool
    {
        return Str::endsWith($this->slug, '_index');
    }

    public function getRepositoryAttribute(): string
    {
        [$repository] = explode('/', $this->slug);

        return $repository;
    }

    public function getAliasAttribute(): string
    {
        [, $alias] = explode('/', $this->slug);

        return $alias;
    }

    public function getSectionAttribute(): ?string
    {
        $parts = explode('/', $this->slug);

        if (count($parts) === 3) {
            return '_root';
        }

        return array_reverse($parts)[1];
    }

    public function getUrlAttribute(): ?string
    {
        $path = Str::beforeLast($this->getPath(), '.md');

        return action(DocsController::class, ['documentationPage' => $path]);
    }
}
