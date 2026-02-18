<?php

namespace App\Support\MarkdownResponse;

use Spatie\MarkdownResponse\Postprocessors\Postprocessor;

class CleanUpDocsMarkdownPostprocessor implements Postprocessor
{
    public function __invoke(string $markdown): string
    {
        // Remove permalink anchors like [\#](#content-some-heading "Permalink")
        $markdown = preg_replace('/\[\\\\?#\]\(#[^)]*"Permalink"\)/', '', $markdown);

        // Remove "Copy as markdown" / "Copied!" text (can appear on same line)
        $markdown = preg_replace('/\s*Copy as markdown\s*Copied!\s*/', '', $markdown);
        $markdown = preg_replace('/^\s*Copy as markdown\s*$/m', '', $markdown);
        $markdown = preg_replace('/^\s*Copied!\s*$/m', '', $markdown);

        // Remove Alpine.js/Livewire remnants from search modal
        $markdown = preg_replace('/\{[^}]*isOpen\s*=\s*true[^}]*\}[^\n]*/', '', $markdown);

        // Remove "ESC" text from search modal remnants
        $markdown = preg_replace('/^\s*ESC\s*$/m', '', $markdown);

        // Remove "Enter a search term to find results in the documentation."
        $markdown = preg_replace('/^\s*Enter a search term to find results in the documentation\.\s*$/m', '', $markdown);

        // Remove "Help us improve this page" lines
        $markdown = preg_replace('/.*Help us improve this page.*/m', '', $markdown);

        // Remove orphaned ordered list items (e.g. "1." from empty search modal list)
        $markdown = preg_replace('/^\s*\d+\.\s*$/m', '', $markdown);

        return $markdown;
    }
}
