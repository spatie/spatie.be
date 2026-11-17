<?php

namespace App\Actions;

use Dom\HTMLDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\HTMLToMarkdown\Converter\TableConverter;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\HttpFoundation\AcceptHeader;

class CreateArticleMarkdownResponseAction
{
    public function isRequested(Request $request): bool
    {
        if (! config('markdown-response.enabled', true)) {
            return false;
        }

        if ($request->attributes->get('markdown-response.suffix')) {
            return true;
        }

        $accept = AcceptHeader::fromString($request->header('Accept'));

        return ($accept->get('text/markdown')?->getQuality() ?? 0)
            > ($accept->get('text/html')?->getQuality() ?? 0);
    }

    /** @param array<string, ?string> $metadata */
    public function execute(string $title, string $html, string $sourceUrl, array $metadata = []): Response
    {
        $document = HTMLDocument::createFromString('<!DOCTYPE html><html><body>'.$html.'</body></html>', LIBXML_NOERROR, 'UTF-8');

        foreach ($document->querySelectorAll('pre span, code span') as $span) {
            $span->replaceWith($span->textContent);
        }

        foreach ($document->querySelectorAll('a.anchor-link') as $anchor) {
            $anchor->remove();
        }

        $converter = new HtmlConverter([
            'strip_tags' => true,
            'remove_nodes' => 'script style noscript',
            'header_style' => 'atx',
        ]);
        $converter->getEnvironment()->addConverter(new TableConverter());

        $context = collect(['Source' => $sourceUrl, ...$metadata])
            ->filter(fn (?string $value) => $value !== null && $value !== '')
            ->map(fn (string $value, string $label) => '<p>'.e("{$label}: {$value}").'</p>')
            ->implode("\n");

        $markdown = $converter->convert('<h1>'.e($title)."</h1>\n".$context."\n".$document->querySelector('body')->innerHTML);

        return response($markdown, headers: [
            'Content-Type' => 'text/markdown; charset=UTF-8',
            'Vary' => 'Accept',
            'Cache-Control' => 'private, no-store',
            'X-Robots-Tag' => 'noindex',
        ]);
    }
}
