<?php

namespace App\Support\MarkdownResponse;

use DOMDocument;
use DOMXPath;
use Spatie\MarkdownResponse\Preprocessors\Preprocessor;

class RemoveCodeHighlightingPreprocessor implements Preprocessor
{
    public function __invoke(string $html): string
    {
        if (trim($html) === '') {
            return $html;
        }

        $document = new DOMDocument();
        $document->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_NOERROR | LIBXML_NOWARNING);

        $xpath = new DOMXPath($document);

        foreach ($xpath->query('//pre[not(code)] | //code') as $code) {
            $text = $document->createTextNode($code->textContent);

            while ($code->firstChild) {
                $code->removeChild($code->firstChild);
            }

            $code->appendChild($text);
        }

        return $document->saveHTML();
    }
}
