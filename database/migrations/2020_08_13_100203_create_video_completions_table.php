<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoCompletionsTable extends Migration
{
    public function up()
    {
        Schema::create('video_completions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('video_id');
            $table->timestamps();

            $table->index(['user_id', 'video_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('video_id')->references('id')->on('videos');
        });
    }
}
