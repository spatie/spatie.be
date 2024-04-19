<?php

namespace App\Docs\Highlighting;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\ParsedInjection;

class DiffAdditionInjection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $content = preg_replace_callback(
            '/^\+(.*)$/m', // Matches lines starting with '+'
            function ($matches) {
                $open = Escape::tokens('<span class="hl-addition">+ ');
                $close = Escape::tokens('</span>');

                return $open . $matches[1] . $close; // Wraps the matched line with the span
            },
            $content
        );

        return new ParsedInjection($content);
    }
}
