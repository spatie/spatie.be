<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAchievementsTable extends Migration
{
    public function up()
    {
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedBigInteger('achievement_id')->nullable();
            $table->string('slug');
            $table->string('title');
            $table->string('description');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('achievement_id')->references('id')->on('achievements');
            $table->index('email');
        });
    }
}
