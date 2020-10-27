<?php

namespace App\Docs;

use App\Support\CommonMark\ImageRenderer;
use App\Support\CommonMark\LinkRenderer;
use Illuminate\Support\HtmlString;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Inline\Element\Image;
use League\CommonMark\Inline\Element\Link;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class DocumentationContentParser implements \Spatie\Sheets\ContentParser
{
    protected CommonMarkConverter $commonMarkConverter;

    public function __construct()
    {
        $environment = Environment::createCommonMarkEnvironment();

        $environment->addInlineRenderer(Image::class, new ImageRenderer());
        $environment->addInlineRenderer(Link::class, new LinkRenderer());

        $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer(['html', 'php', 'js', 'ts', 'css']));
        $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer(['html', 'php', 'js', 'ts', 'css']));
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new HeadingPermalinkExtension());

        $config = [
            'heading_permalink' => [
                'html_class' => 'anchor-link',
                'symbol' => '#',
            ],
        ];

        $this->commonMarkConverter = new CommonMarkConverter($config, $environment);
    }

    public function parse(string $contents): array
    {
        $document = YamlFrontMatter::parse($contents);

        $htmlContents = $this->commonMarkConverter->convertToHtml($document->body());

        return array_merge(
            $document->matter(),
            ['contents' => new HtmlString($htmlContents)]
        );
    }
}
