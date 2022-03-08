<?php

namespace App\Models;

use App\Actions\GenerateHtmlLessonHtmlAction;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class HtmlLesson extends Model
{
    public static function booted()
    {
        self::saving(function (HtmlLesson $htmlLesson) {
            app(GenerateHtmlLessonHtmlAction::class)->execute($htmlLesson);
        });
    }
}
