<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('type');
            $table->string('certificate_template_path')->nullable()->after('image_path');
        });

        Schema::table('user_achievements', function (Blueprint $table) {
            $table->string('og_image_path')->nullable()->after('description');
            $table->string('certificate_path')->nullable()->after('og_image_path');
        });
    }
};
