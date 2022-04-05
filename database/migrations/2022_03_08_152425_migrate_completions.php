<?php

use App\Models\LessonCompletion;
use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        DB::table('video_completions')->orderBy('id')->each(function (stdClass $completion) {
            if (! $video = Video::find($completion->video_id)) {
                return;
            }

            if (! $lesson = $video->lesson) {
                return;
            }

            LessonCompletion::create([
                'user_id' => $completion->user_id,
                'lesson_id' => $lesson->id,
            ]);
        });

        Schema::drop('video_completions');
    }
};
