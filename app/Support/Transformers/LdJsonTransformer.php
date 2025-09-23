<?php

namespace App\Support\Transformers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\LaravelUrlAiTransformer\Transformers\LdJsonTransformer as BaseLdJsonTransformer;

class LdJsonTransformer extends BaseLdJsonTransformer
{
    public function shouldRun(): bool
    {
        /** @var Carbon|null $completedAt */
        $completedAt = $this->transformationResult->successfully_completed_at;

        if (is_null($completedAt)) {
            return true;
        }

        return ! $completedAt->isCurrentWeek();
    }

    public function prompt(): string
    {
        $content = Str::limit(strip_tags($this->urlContent), 6000);

        return "Summarize the following webpage to ld+json. Only return valid json, no backtick openings. Make the snippet as complete as possible. Do not add 'potentialAction' key or type 'searchAction'. This is the content that we fetched for url  {$this->url}: {$content}";
    }
}
