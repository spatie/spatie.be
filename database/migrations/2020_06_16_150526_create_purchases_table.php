<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedBigInteger('license_id')->nullable();
            $table->foreign('license_id')->references('id')->on('licenses');

            $table->string('payment_method');
            $table->string('receipt_url');
            $table->json('paddle_webhook_payload');
            $table->string('paddle_fee');
            $table->string('payment_tax');
            $table->string('earnings');
            $table->string('paddle_alert_id');


            $table->timestamps();
        });
    }
}
