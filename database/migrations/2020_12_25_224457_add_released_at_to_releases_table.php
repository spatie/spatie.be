<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReleasedAtToReleasesTable extends Migration
{
    public function up()
    {
        Schema::table('releases', function (Blueprint $table) {
            $table->timestamp('released_at')->nullable();
        });
    }
}
