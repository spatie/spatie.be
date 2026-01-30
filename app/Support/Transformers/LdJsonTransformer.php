<?php

namespace App\Support\Transformers;

use Illuminate\Support\Str;
use Prism\Prism\Prism;
use Spatie\LaravelUrlAiTransformer\Support\Config;
use Spatie\LaravelUrlAiTransformer\Transformers\Transformer;

class LdJsonTransformer extends Transformer
{
    public function getPrompt(): string
    {
        $content = Str::limit(strip_tags($this->urlContent), 6000);

        return "Summarize the following webpage to ld+json. Only return valid json. This json will directly be included on the page.  This is the content that we fetched for url {$this->url}: {$content}";
    }

    public function transform(): void
    {
        $response = Prism::text()
            ->using(Config::aiProvider(), Config::aiModel())
            ->withPrompt($this->getPrompt())
            ->asText();

        $this->transformationResult->result = $response->text;
    }
}
