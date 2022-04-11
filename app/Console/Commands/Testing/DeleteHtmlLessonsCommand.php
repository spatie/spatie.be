<?php

namespace App\Console\Commands\Testing;

use App\Models\HtmlLesson;
use App\Models\Lesson;
use Illuminate\Console\Command;

class DeleteHtmlLessonsCommand extends Command
{
    protected $signature = 'delete-seeded-html-lessons';

    public function handle()
    {
        HtmlLesson::truncate();

        Lesson::where('series_id', 7)->get()->each->delete();
    }
}
