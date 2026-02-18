<?php

namespace App\Support\MarkdownResponse;

use DOMDocument;
use DOMXPath;
use Spatie\MarkdownResponse\Preprocessors\Preprocessor;

class ExtractDocsContentPreprocessor implements Preprocessor
{
    public function __invoke(string $html): string
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED);

        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        $extractedHtml = $this->extractTitle($xpath)
            .$this->extractContent($xpath);

        if ($extractedHtml === '') {
            return $html;
        }

        return $extractedHtml;
    }

    protected function extractTitle(DOMXPath $xpath): string
    {
        $title = $xpath->query('//article//h1')->item(0)
            ?? $xpath->query('//article//h2')->item(0);

        if (! $title) {
            return '';
        }

        return $title->ownerDocument->saveHTML($title);
    }

    protected function extractContent(DOMXPath $xpath): string
    {
        $content = $xpath->query('//*[@id="site-search-docs-content"]')->item(0);

        if (! $content) {
            return '';
        }

        return $content->ownerDocument->saveHTML($content);
    }
}
