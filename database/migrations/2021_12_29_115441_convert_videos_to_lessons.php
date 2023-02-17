<?php

use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Video::each(function (Video $video) {
            Lesson::create([
                'content_type' => 'video',
                'content_id' => $video->id,
                'series_id' => $video->series_id,
                'title' => $video->title,
                'slug' => $video->slug,
                'sort_order' => $video->sort_order,
                'display' => $video->display,
                'chapter' => $video->chapter,
            ]);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign('videos_series_id_foreign');
            $table->dropColumn(['slug', 'sort_order', 'series_id', 'chapter']);
        });
    }
};
