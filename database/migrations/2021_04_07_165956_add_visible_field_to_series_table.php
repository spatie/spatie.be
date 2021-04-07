<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibleFieldToSeriesTable extends Migration
{
    public function up()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->boolean('visible')->default(true);
        });
    }
}
