<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('role');
            $table->string('description', 1000);
            $table->string('email');
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
            $table->boolean('founder')->default(false);
            $table->boolean('public_email')->default(false);
            $table->timestamps();
        });
    }
}
