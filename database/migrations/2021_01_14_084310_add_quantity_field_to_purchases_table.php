<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityFieldToPurchasesTable extends Migration
{
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->integer('quantity')->default(1);
            $table->dropColumn('license_id');
            $table->json('passthrough');
        });

        Schema::table('license', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
    }
}
