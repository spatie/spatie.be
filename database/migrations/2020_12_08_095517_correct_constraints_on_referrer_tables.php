<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('referrer_purchasable', function (Blueprint $table) {
            $table->dropForeign('referrer_purchasable_referrer_id_foreign');
            $table->foreign('referrer_id')->references('id')->on('referrers')->cascadeOnDelete();

            $table->dropForeign('referrer_purchasable_purchasable_id_foreign');
            $table->foreign('purchasable_id')->references('id')->on('purchasables')->cascadeOnDelete();
        });

        Schema::table('referrer_purchases', function (Blueprint $table) {
            $table->dropForeign('referrer_purchases_referrer_id_foreign');
            $table->foreign('referrer_id')->references('id')->on('referrers')->cascadeOnDelete();

            $table->dropForeign('referrer_purchases_purchase_id_foreign');
            $table->foreign('purchase_id')->references('id')->on('purchases')->cascadeOnDelete();
        });
    }
};
