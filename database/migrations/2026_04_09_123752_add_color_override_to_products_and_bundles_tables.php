<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('color', 7)->nullable()->after('visible');
        });

        Schema::table('bundles', function (Blueprint $table) {
            $table->string('color', 7)->nullable()->after('visible');
        });
    }
};
