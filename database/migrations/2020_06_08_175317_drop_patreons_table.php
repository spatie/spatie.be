<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPatreonsTable extends Migration
{
    public function up()
    {
        Schema::drop('patreon_pledgers');
    }
}
