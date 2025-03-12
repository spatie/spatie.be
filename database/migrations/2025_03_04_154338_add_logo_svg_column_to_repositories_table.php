<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('repositories', function (Blueprint $table) {
            $table->longText('logo_svg')->nullable();
            $table->string('accent_color')->nullable();
        });
    }
};
