<?php

namespace App\Support\Transformers;

use Illuminate\Support\Str;
use Prism\Prism\Prism;
use Spatie\LaravelUrlAiTransformer\Support\Config;
use Spatie\LaravelUrlAiTransformer\Transformers\Transformer;

class MarkdownTransformer extends Transformer
{
    public function transform(): void
    {
        $response = Prism::text()
            ->using(Config::aiProvider(), Config::aiModel())
            ->withPrompt($this->getPrompt())
            ->asText();

        $this->transformationResult->result = $response->text;
    }

    public function getPrompt(): string
    {
        return 'Summarize the following webpage to markdown. I expect three list items. Do not use any other formatting. Do not included markdown tags themselves. This is the content:'.Str::limit($this->urlContent, 6000);
    }
}
