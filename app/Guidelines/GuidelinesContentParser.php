<?php

namespace App\Guidelines;

use Illuminate\Support\HtmlString;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\Sheets\ContentParser;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class GuidelinesContentParser implements ContentParser
{
    protected MarkdownRenderer $markdownRenderer;

    public function __construct()
    {
        /** @var MarkdownRenderer $renderer */
        $this->markdownRenderer = app(MarkdownRenderer::class)
            ->addExtension(new TableOfContentsExtension())
            ->addExtension(new HeadingPermalinkExtension())
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

        //$environment->addInlineRenderer(Image::class, new ImageRenderer());
        //$environment->addInlineRenderer(Link::class, new LinkRenderer());
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
