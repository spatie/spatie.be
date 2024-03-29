<?php

namespace App\Docs;

use App\Support\CommonMark\ImageRenderer;
use App\Support\CommonMark\LinkRenderer;
use Illuminate\Support\HtmlString;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Table\TableExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;
use Tempest\Highlight\CommonMark\InlineCodeBlockRenderer;

class DocumentationContentParser extends MarkdownWithFrontMatterParser
{
    protected MarkdownRenderer $markdownRenderer;

    public function __construct()
    {
        $this->markdownRenderer = app(MarkdownRenderer::class)
            ->highlightCode(false)
            ->addExtension(new TableExtension())
            ->addExtension(new HeadingPermalinkExtension())
            ->addInlineRenderer(Image::class, new ImageRenderer())
            ->addInlineRenderer(Link::class, new LinkRenderer())
            ->addInlineRenderer(FencedCode::class, new CodeBlockRenderer(), 10)
            ->addInlineRenderer(Code::class, new InlineCodeBlockRenderer(), 10)
            ->commonmarkOptions([
                'heading_permalink' => [
                    'html_class' => 'anchor-link',
                    'symbol' => '#',
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
