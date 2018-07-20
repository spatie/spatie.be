<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebsiteToInsightsTable extends Migration
{
    public function up()
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->string('website')->nullable();
        });
    }
}
