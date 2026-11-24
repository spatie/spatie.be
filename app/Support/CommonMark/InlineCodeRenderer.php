<?php

namespace App\Support\CommonMark;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use Tempest\Highlight\Highlighter;

class InlineCodeRenderer implements NodeRendererInterface
{
    public function __construct(
        protected Highlighter $highlighter,
    ) {
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (! $node instanceof Code) {
            throw new InvalidArgumentException('Inline must be instance of '.Code::class);
        }

        $code = $node->getLiteral();
        $language = 'txt';

        if (preg_match('/^\{(?<language>\w+)}(?<code>.*)/', $code, $matches)) {
            if (in_array($matches['language'], $this->highlighter->getSupportedLanguageNames(), true)) {
                $language = $matches['language'];
                $code = $matches['code'];
            }
        }

        return '<code>'.$this->highlighter->parse($code, $language).'</code>';
    }
}
