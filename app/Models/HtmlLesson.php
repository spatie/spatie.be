<?php

namespace App\Models;

use App\Actions\GenerateHtmlLessonHtmlAction;
use Illuminate\Database\Eloquent\Model;

class HtmlLesson extends Model
{
    public static function booted()
    {
        self::saving(function (HtmlLesson $htmlLesson) {
            app(GenerateHtmlLessonHtmlAction::class)->execute($htmlLesson);
        });
    }
}
