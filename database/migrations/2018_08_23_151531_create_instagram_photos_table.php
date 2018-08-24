<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstagramPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instagram_photos');
    }
}
