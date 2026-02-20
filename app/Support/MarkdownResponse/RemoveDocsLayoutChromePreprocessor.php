<?php

namespace App\Support\MarkdownResponse;

use DOMDocument;
use DOMXPath;
use Spatie\MarkdownResponse\Preprocessors\Preprocessor;

class RemoveDocsLayoutChromePreprocessor implements Preprocessor
{
    public function __invoke(string $html): string
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED);

        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        $this->removeElements($xpath, '//header');
        $this->removeElements($xpath, '//footer');
        $this->removeElements($xpath, '//aside');

        // Remove the search modal (Livewire spotlight component)
        $this->removeElements($xpath, '//*[contains(@class, "fixed") and contains(@class, "z-50")]');

        // Remove "Help us improve this page" links
        $this->removeElements($xpath, '//a[contains(text(), "Help us improve this page")]');

        // Remove the wallpaper background image
        $this->removeElements($xpath, '//*[contains(@class, "wallpaper")]');

        // Remove telephone modal (rendered outside footer)
        $this->removeElements($xpath, '//*[@id="tel"]');

        // Remove prev/next page navigation
        $this->removeElements($xpath, '//*[contains(@class, "bg-link-card-light")]');

        // Remove noscript tags (Google Tag Manager iframes)
        $this->removeElements($xpath, '//noscript');

        return $dom->saveHTML();
    }

    protected function removeElements(DOMXPath $xpath, string $expression): void
    {
        $elements = $xpath->query($expression);

        foreach ($elements as $element) {
            $element->parentNode->removeChild($element);
        }
    }
}
