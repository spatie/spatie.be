<?php

namespace App\Domain\Blog\Actions;

use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;

class RenderBlogMarkdownAction
{
    public function execute(string $markdown): string
    {
        return (new MarkdownRenderer())
            ->cacheStoreName(false)
            ->highlightCode(false)
            ->disableAnchors()
            ->addExtension(new TableExtension())
            ->addExtension(new StrikethroughExtension())
            ->addBlockRenderer(FencedCode::class, new CodeBlockRenderer(), 10)
            ->commonmarkOptions(['allow_unsafe_links' => false])
            ->toHtml($markdown);
    }
}
