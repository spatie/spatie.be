<?php

namespace App\Support\CommonMark;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;

class RustCodeBlockRenderer implements NodeRendererInterface
{
    public function __construct(
        protected CodeBlockRenderer $renderer,
    ) {
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (! $node instanceof FencedCode) {
            throw new InvalidArgumentException('Block must be instance of '.FencedCode::class);
        }

        if (! preg_match('/^(rust|rs)($|[,\{])/', $node->getInfoWords()[0] ?? '')) {
            return $this->renderer->render($node, $childRenderer);
        }

        $lines = [];

        foreach (explode("\n", $node->getLiteral()) as $line) {
            $trimmed = trim($line);

            if (str_starts_with($trimmed, '##')) {
                $lines[] = substr_replace($line, '#', strpos($line, '##'), 2);

                continue;
            }

            if ($trimmed === '#' || str_starts_with($trimmed, '# ')) {
                continue;
            }

            $lines[] = $line;
        }

        $node = clone $node;
        $node->setLiteral(implode("\n", $lines));

        return $this->renderer->render($node, $childRenderer);
    }
}
