<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('conversion_rates', function (Blueprint $table) {
            $table->string('currency_symbol')->nullable();
        });

        Schema::table('purchasable_prices', function (Blueprint $table) {
            $table->string('currency_symbol')->nullable();
        });
    }
};
