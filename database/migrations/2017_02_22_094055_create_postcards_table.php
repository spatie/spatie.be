<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostcardsTable extends Migration
{
    public function up()
    {
        Schema::create('postcards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender');
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
    }
}
