<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClickCountToReferrersTable extends Migration
{
    public function up()
    {
        Schema::table('referrers', function (Blueprint $table) {
            $table->integer('click_count')->default(0);
            $table->timestamp('last_clicked_at')->nullable();
        });
    }
}
