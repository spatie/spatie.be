<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIssuesTable extends Migration
{
    public function up()
    {
        Schema::drop('issues');
    }
}
