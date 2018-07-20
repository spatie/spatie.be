<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTweetedAtColumnToIssuesTable extends Migration
{
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->timestamp('tweeted_at')->nullable();
        });
    }
}
