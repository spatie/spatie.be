<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('html_lessons', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('markdown');
            $table->longText('html')->nullable();

            $table->timestamps();
        });
    }
};
