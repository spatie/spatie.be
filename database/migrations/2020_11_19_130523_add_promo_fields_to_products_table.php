<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('coupon_code')->nullable();
            $table->integer('coupon_percentage')->nullable();
            $table->timestamp('coupon_valid_from')->nullable();
            $table->timestamp('coupon_expires_at')->nullable();
            $table->string('coupon_label')->nullable();
        });
    }
};
