<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('purchasable_id');
            $table->foreign('purchasable_id')->references('id')->on('purchasables')->onDelete('cascade');

            $table->string('key');
            $table->integer('satis_authentication_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }
}
