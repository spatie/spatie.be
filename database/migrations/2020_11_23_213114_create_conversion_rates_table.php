<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('conversion_rates', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->string('currency_code');
            $table->double('ppp_conversion_factor');
            $table->double('exchange_rate');
            $table->timestamps();
        });
    }
};
