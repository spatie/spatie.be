<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropContributorsTable extends Migration
{
    public function up()
    {
        Schema::drop('contributors');
    }
}
