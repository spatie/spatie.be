<?php

namespace App\Console\Commands;

use App\Actions\GenerateHtmlLessonHtmlAction;
use App\Models\HtmlLesson;
use Illuminate\Console\Command;

class RegenerateHtmlLessonHtmlCommand extends Command
{
    protected $signature = 'regenerate-html-lessons-html';

    public function handle(): void
    {
        $this->info('Regenerating html...');

        HtmlLesson::each(function (HtmlLesson $htmlLesson) {
            $this->comment("Regenerating html for html lesson id {$htmlLesson->id}");

            return app(GenerateHtmlLessonHtmlAction::class)->execute($htmlLesson);
        });

        $this->info('All done');
    }
}
