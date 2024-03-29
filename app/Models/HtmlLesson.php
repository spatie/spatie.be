<?php

namespace App\Models;

use App\Actions\GenerateHtmlLessonHtmlAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlLesson extends Model
{
    public static function booted()
    {
        self::saving(function (HtmlLesson $htmlLesson) {
            app(GenerateHtmlLessonHtmlAction::class)->execute($htmlLesson);
        });
    }

    public function lesson(): MorphOne
    {
        return $this->morphOne(Lesson::class, 'content');
    }
}
