<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uuid');
            $table->foreignId('license_id')->constrained()->cascadeOnDelete();
            $table->json('signed_activation')->nullable();
            $table->timestamps();
        });

        Schema::table('licenses', function (Blueprint $table) {
            $table->dropColumn('signed_license');
        });
    }
};
