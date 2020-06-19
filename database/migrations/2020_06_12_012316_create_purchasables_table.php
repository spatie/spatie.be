<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasablesTable extends Migration
{
    public function up()
    {
        Schema::create('purchasables', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description');
            $table->integer('sort_order');
            $table->string('type');
            $table->boolean('requires_license')->default(0);
            $table->string('paddle_product_id');

            $table->unsignedBigInteger('product_id');

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }
}
