<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraAttributesToPackagesTable extends Migration
{
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('new')->default(false);
            $table->boolean('highlighted')->default(false);
            $table->string('type')->nullable();
            $table->string('language')->nullable();
        });
    }
}
