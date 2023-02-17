<?php

use App\Models\Series;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->morphs('content');
            $table->string('chapter')->nullable();
            $table->string('chapter_slug')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->integer('sort_order');
            $table->string('display');
            $table->foreignIdFor(Series::class);
            $table->timestamps();
        });

        Schema::table('series', function (Blueprint $table) {
            $table->string('type');
        });
    }
};
