<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePackagesTable extends Migration
{
    public function up()
    {
        Schema::rename('packages', 'repositories');

        Schema::table('issues', function (Blueprint $table) {
            $table->renameColumn('package_id', 'repository_id');
        });
    }
}
