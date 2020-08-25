<?php

namespace App\Support\Sheets;

use Illuminate\Support\HtmlString;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Inline\Element\Image;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class ContentParser implements \Spatie\Sheets\ContentParser
{
    protected CommonMarkConverter $commonMarkConverter;

    public function __construct()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addInlineRenderer(Image::class, new ImageRenderer());
        $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer());
        $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer());
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
