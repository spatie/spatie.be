<?php

namespace App\Support\Transformers;

use Illuminate\Support\Str;
use Spatie\LaravelUrlAiTransformer\Transformers\LdJsonTransformer as BaseLdJsonTransformer;

class LdJsonTransformer extends BaseLdJsonTransformer
{
    public function prompt(): string
    {
        $content = Str::limit(strip_tags($this->urlContent), 6000);

        return "Summarize the following webpage to ld+json. Only return valid json, no backtick openings.  This is the content that we fetched for url {$this->url}: {$content}";
    }
}
