<?php

namespace App\Providers;

use App\Support\Transformers\LdJsonTransformer;
use App\Support\Transformers\MarkdownTransformer;
use Illuminate\Support\ServiceProvider;
use Spatie\LaravelUrlAiTransformer\Support\Transform;

class AiTransformerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Transform::urls(
            '/',
            '/about-us'
        )->usingTransformers(
            new LdJsonTransformer(),
            new MarkdownTransformer()
        );
    }
}
