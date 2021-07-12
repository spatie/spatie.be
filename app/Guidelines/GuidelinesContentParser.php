<?php

namespace App\Guidelines;

use App\Support\CommonMark\ImageRenderer;
use App\Support\CommonMark\LinkRenderer;
use Illuminate\Support\HtmlString;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Inline\Element\Image;
use League\CommonMark\Inline\Element\Link;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\Sheets\ContentParser;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class GuidelinesContentParser implements ContentParser
{
    protected MarkdownRenderer $markdownRenderer;

    public function __construct()
    {
        $this->markdownRenderer = app(MarkdownRenderer::class)
            ->addExtension(new TableOfContentsExtension())
            ->addExtension(new HeadingPermalinkExtension())
            ->addInlineRenderer(Image::class, new ImageRenderer())
            ->addInlineRenderer(Link::class, new LinkRenderer())
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
                    'normalize' => 'flat',
                    'placeholder' => null,
                ],
            ]);
    }

    public function parse(string $contents): array
    {
        $document = YamlFrontMatter::parse($contents);

        $htmlContents = $this->markdownRenderer->toHtml($document->body());

        return array_merge(
            $document->matter(),
            ['contents' => new HtmlString($htmlContents)]
        );
    }
}
