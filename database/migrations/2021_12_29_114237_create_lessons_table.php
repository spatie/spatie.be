<?php

use App\Models\Lesson;
use App\Models\Series;
use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->morphs('content');
            $table->string('chapter')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->integer('sort_order');
            $table->string('display');
            $table->foreignIdFor(Series::class);
            $table->timestamps();
        });
    }
}
