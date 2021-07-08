<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchasable_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchasable_id')->constrained()->cascadeOnDelete();
            $table->string('country_code');
            $table->string('currency_code');
            $table->integer('amount');
            $table->boolean('overridden')->default(false);
            $table->timestamps();
        });
    }
};
