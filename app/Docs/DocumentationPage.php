<?php

namespace App\Docs;

use App\Http\Front\Controllers\DocsController;
use Illuminate\Support\Str;
use Spatie\Sheets\Sheet;

class DocumentationPage extends Sheet
{
    public function isIndex(): bool
    {
        return Str::endsWith($this->slug, '_index');
    }

    public function isRootSection(): bool
    {
        return $this->getSectionAttribute() === '_root';
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

    public function getPageAttribute(): string
    {
        return Str::after($this->slug, "{$this->getRepositoryAttribute()}/{$this->getAliasAttribute()}/");
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
        return action([DocsController::class, 'show'], [
            'repository' => $this->getRepositoryAttribute(),
            'alias' => $this->getAliasAttribute(),
            'page' => $this->getPageAttribute(),
        ]);
    }
}
