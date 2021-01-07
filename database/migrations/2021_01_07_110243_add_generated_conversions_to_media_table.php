<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeneratedConversionsToMediaTable extends Migration
{
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->json('generated_conversions')
        });
    }
}
