<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', static function (Blueprint $table) {
            $table->string('preferred_name')
                ->nullable()
                ->after('last_name');

            $table->string('birthday')
                ->nullable()
                ->after('public_email');
        });
    }
};
