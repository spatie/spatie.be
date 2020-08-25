<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDomainToLicensesTable extends Migration
{
    public function up()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->string('domain')->nullable()->after('key');
        });
    }
}
