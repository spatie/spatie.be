<?php

namespace App\Guidelines;

use App\Support\CommonMark\ImageRenderer;
use App\Support\CommonMark\LinkRenderer;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\Sheets\ContentParser;
use Spatie\SidecarShiki\Commonmark\HighlightCodeExtension;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class GuidelinesContentParser implements ContentParser
{
    protected MarkdownRenderer $markdownRenderer;

    public function __construct()
    {
        $this->markdownRenderer = app(MarkdownRenderer::class)
            ->highlightCode(false)
            ->addExtension(new HighlightCodeExtension('github-light'))
            ->disableAnchors()
            ->addExtension(new TableOfContentsExtension())
            ->commonmarkOptions([
                'heading_permalink' => [
                    'html_class' => 'anchor-link',
                    'symbol' => '#',
                ],

                'table_of_contents' => [
                    'html_class' => 'text-xs space-y-1 links-blue',
                    'position' => 'top',
                    'style' => 'bullet',
                    'min_heading_level' => 2,
                    'max_heading_level' => 2,
                    'placeholder' => null,
                    'normalize' => 'flat',
                ],
            ])
            ->addInlineRenderer(Image::class, new ImageRenderer())
            ->addInlineRenderer(Link::class, new LinkRenderer());
    }

    public function parse(string $contents): array
    {
        $document = YamlFrontMatter::parse($contents);

        $htmlContents = $this->markdownRenderer->toHtml($document->body());

        $htmlContents = Str::of($htmlContents)
            ->replace('[good]', '<div class="shiki-good">')
            ->replace('[bad]', '<div class="shiki-bad">')
            ->replace(['[/good]', '[/bad]'], '</div>')
            ->toString();

        return array_merge(
            $document->matter(),
            ['contents' => new HtmlString($htmlContents)]
        );
    }
}
