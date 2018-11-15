<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatreonPledgersTable extends Migration
{
    public function up()
    {
        Schema::create('patreon_pledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patreon_id');
            $table->string('name');
            $table->string('avatar_url');
            $table->timestamps();
        });
    }
}
