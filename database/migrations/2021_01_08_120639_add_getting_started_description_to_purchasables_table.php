<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('purchasables', function (Blueprint $table) {
            $table->text('getting_started_description')->after('getting_started_url')->nullable();
        });
    }
};
