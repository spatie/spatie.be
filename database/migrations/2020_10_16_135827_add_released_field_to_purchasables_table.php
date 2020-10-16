<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReleasedFieldToPurchasablesTable extends Migration
{
    public function up()
    {
        Schema::table('purchasables', function (Blueprint $table) {
            $table->boolean('released')->default(false);
        });
    }
}
