<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreencastsTables extends Migration
{
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->integer('sort');
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id');
            $table->string('vimeo_id');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('sort');
            $table->integer('runtime');
            $table->string('thumbnail');
            $table->boolean('only_for_sponsors');
            $table->timestamps();

            $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
        });
    }
}
