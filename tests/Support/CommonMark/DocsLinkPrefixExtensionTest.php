<?php

namespace Tests\Support\CommonMark;

use App\Support\CommonMark\DocsLinkPrefixExtension;
use App\Support\CommonMark\LinkRenderer;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use Spatie\CommonMarkWireNavigate\WireNavigateExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;

function renderDocsMarkdown(string $markdown): string
{
    return app(MarkdownRenderer::class)
        ->highlightCode(false)
        ->addExtension(new DocsLinkPrefixExtension())
        ->addExtension(new WireNavigateExtension())
        ->addInlineRenderer(Link::class, new LinkRenderer())
        ->commonmarkOptions([
            'wire_navigate' => ['paths' => ['docs']],
        ])
        ->toHtml($markdown);
}

it('prefixes root-relative links with /docs', function () {
    $html = renderDocsMarkdown('[fluent methods](/laravel-html/general-usage/element-methods)');

    expect($html)->toContain('href="/docs/laravel-html/general-usage/element-methods"');
});

it('marks prefixed docs links for wire:navigate', function () {
    $html = renderDocsMarkdown('[fluent methods](/laravel-html/general-usage/element-methods)');

    expect($html)->toContain('wire:navigate');
});

it('does not double prefix links that already start with /docs', function () {
    $html = renderDocsMarkdown('[comments](/docs/laravel-comments/v2/basic-usage/transforming-comments)');

    expect($html)
        ->toContain('href="/docs/laravel-comments/v2/basic-usage/transforming-comments"')
        ->not->toContain('/docs/docs/');
});

it('leaves absolute urls untouched', function () {
    $html = renderDocsMarkdown('[newsletter](https://spatie.be/newsletter)');

    expect($html)
        ->toContain('href="https://spatie.be/newsletter"')
        ->not->toContain('/docs/');
});
