<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('click_redirect_url');
            $table->string('image');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::table('repositories', function (Blueprint $table) {
            $table->unsignedBigInteger('ad_id')->nullable();
            $table->boolean('ad_should_be_randomized')->default(true);
            $table->foreign('ad_id')->references('id')->on('ads');
        });
    }
}
