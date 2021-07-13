<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExperiencesTable extends Migration
{
    public function up()
    {
        Schema::create('user_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
