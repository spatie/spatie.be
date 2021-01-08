<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGettingStartedDescriptionToPurchasablesTable extends Migration
{
    public function up()
    {
        Schema::table('purchasables', function (Blueprint $table) {
            $table->text('getting_started_description')->after('getting_started_url')->nullable();
        });
    }
}
