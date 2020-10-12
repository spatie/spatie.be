<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchasablesAddSatisPackages extends Migration
{
    public function up()
    {
        Schema::table('purchasables', function (Blueprint $table) {
            $table->json('satis_packages')->nullable();
        });
    }
}
