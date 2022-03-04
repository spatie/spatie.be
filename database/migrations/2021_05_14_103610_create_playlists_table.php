<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('spotify_url');
            $table->string('apple_music_url');

            $table->timestamps();
        });
    }
};
