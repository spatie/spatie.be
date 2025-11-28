<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('activations', function (Blueprint $table) {
            $table->string('theme')->nullable()->after('os_version');
        });
    }
};
