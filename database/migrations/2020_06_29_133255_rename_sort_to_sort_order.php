<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSortToSortOrder extends Migration
{
    public function up()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->renameColumn('sort', 'sort_order');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->renameColumn('sort', 'sort_order');
        });
    }
}
