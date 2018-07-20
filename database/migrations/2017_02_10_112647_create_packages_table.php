<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('topics')->nullable();
            $table->string('documentation_url')->nullable();
            $table->string('blogpost_url')->nullable();
            $table->integer('stars')->default(0);
            $table->integer('downloads')->nullable();
            $table->timestamps();
        });
    }
}
