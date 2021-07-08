<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->integer('sort_order');
        });

        DB::statement('UPDATE technologies SET sort_order = id');
    }
};
