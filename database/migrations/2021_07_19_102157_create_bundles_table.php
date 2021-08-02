<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->longText('long_description')->nullable();
            $table->integer('price_in_usd_cents');
            $table->integer('sort_order');
            $table->boolean('visible')->default(false);
            $table->string('paddle_product_id');
            $table->timestamps();
        });

        Schema::create('bundle_purchasable', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Bundle::class);
            $table->foreignIdFor(\App\Models\Purchasable::class);
        });

        Schema::create('bundle_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Bundle::class);
            $table->string('country_code');
            $table->string('currency_code');
            $table->integer('amount');
            $table->boolean('overridden')->default(false);
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Bundle::class)->after('purchasable_id')->nullable();
            $table->foreignIdFor(\App\Models\Purchasable::class)->nullable()->change();
        });

        Schema::create('referrer_bundle', function(Blueprint $table) {
            $table->foreignIdFor(\App\Models\Referrer::class);
            $table->foreignIdFor(\App\Models\Bundle::class);
            $table->timestamps();
        });
    }
};
