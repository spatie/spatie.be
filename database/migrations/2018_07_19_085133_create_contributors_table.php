<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributorsTable extends Migration
{
    public function up()
    {
        Schema::create('contributors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('avatar_url');
            $table->string('repository_url');
            $table->string('repository_name');
            $table->timestamps();
        });
    }
}
