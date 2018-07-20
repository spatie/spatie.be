<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibleFieldToRepositoriesTable extends Migration
{
    public function up()
    {
        Schema::table('repositories', function (Blueprint $table) {
            $table->boolean('visible')->default(true);
        });
    }
}
