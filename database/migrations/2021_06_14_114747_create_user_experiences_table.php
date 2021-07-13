<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_experiences', function (Blueprint $table) {
            $table->uuid('uuid')->index();
            $table->unsignedInteger('user_id');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
