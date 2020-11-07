<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrivateKeyToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('private_key')->nullable();
        });

        Schema::table('licenses', function (Blueprint $table) {
            $table->json('signed_license')->nullable();
        });
    }
}
