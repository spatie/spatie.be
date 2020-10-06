<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstagramPhotosTable extends Migration
{
    public function up()
    {
        Schema::create('instagram_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('instagram_id');
            $table->text('description');
            $table->string('url_to_original');
            $table->timestamp('taken_at');
            $table->timestamps();
        });
    }
}
