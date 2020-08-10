<?php

namespace App\Docs;

use App\Http\Controllers\DocsController;
use Illuminate\Support\Str;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use Spatie\Sheets\Sheet;

class DocumentationPage extends Sheet
{
    public function isIndex(): bool
    {
        return Str::endsWith($this->slug, '_index');
    }

    public function getSectionAttribute(): string
    {
        $parts = explode('/', $this->slug);

        if (count($parts) === 1) {
            return '_root';
        }

        return $parts[0];
    }

    public function getUrlAttribute(): ?string
    {
        return action([DocsController::class, 'show'], [
            'repository' => $this->repository,
            'alias' => $this->alias,
            'slug' => $this->slug,
        ]);
    }
}
