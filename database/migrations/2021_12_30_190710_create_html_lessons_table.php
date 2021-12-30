<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHtmlLessonsTable extends Migration
{
    public function up()
    {
        Schema::create('html_lessons', function(Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('markdown');
            $table->longText('html')->nullable();

            $table->timestamps();
        });
    }
}
