<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('flags', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->morphs('flaggable');

            $table->index(['name', 'flaggable_id', 'flaggable_type']);

            $table->timestamps();
        });
    }
};
