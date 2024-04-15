<?php

namespace App\Docs;

use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class DocumentationContentParser extends MarkdownWithFrontMatterParser
{
    public function parse(string $contents): array
    {
        $document = YamlFrontMatter::parse($contents);

        return array_merge(
            $document->matter(),
            /**
             * We don't do any markdown parsing here and
             * only when showing the page instead.
             * @see \App\Http\Controllers\DocsController::show
             */
            ['contents' => $document->body()]
        );
    }
}
