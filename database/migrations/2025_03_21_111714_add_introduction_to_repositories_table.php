<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('repositories', function (Blueprint $table) {
            $table->string('intro_title')->nullable();
            $table->longText('intro_text')->nullable();
            $table->boolean('has_issues')->default(false);
            $table->boolean('light_button_text')->default(false);
        });
    }
};
