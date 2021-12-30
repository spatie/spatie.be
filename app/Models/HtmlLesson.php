<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class HtmlLesson extends Model
{
    public static function booted()
    {
        self::saving(function(HtmlLesson $htmlLesson) {
            $htmlLesson->html = app(MarkdownRenderer::class)->toHtml($htmlLesson->markdown);
        });
    }
}
