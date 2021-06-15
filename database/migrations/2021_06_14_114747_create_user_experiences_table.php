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
            $table->string('email');
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('amount');
            $table->string('type');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->index('email');
        });
    }
}
