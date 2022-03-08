<?php

use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lesson_completions', function(Blueprint $table)
        {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Lesson::class);
        });
    }
};
