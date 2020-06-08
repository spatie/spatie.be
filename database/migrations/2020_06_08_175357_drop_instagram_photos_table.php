<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropInstagramPhotosTable extends Migration
{
    public function up()
    {
        Schema::drop('instagram_photos');
    }
}
