<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('admin_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('google_id')->nullable()->unique();
            $table->timestamps();
        });
    }
};
