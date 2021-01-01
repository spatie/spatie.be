<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArchAndPlatformToActivationsTable extends Migration
{
    public function up()
    {
        Schema::table('activations', function (Blueprint $table) {
            $table->string('arch')->nullable();
            $table->string('platform')->nullable();
        });
    }
}
