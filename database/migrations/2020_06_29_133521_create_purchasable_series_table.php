<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasableSeriesTable extends Migration
{
    public function up()
    {
        Schema::create('purchasable_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchasable_id')->references('id')->on('purchasables');
            $table->foreignId('series_id')->references('id')->on('series');
            $table->unique(['purchasable_id', 'series_id']);
        });
    }
}
