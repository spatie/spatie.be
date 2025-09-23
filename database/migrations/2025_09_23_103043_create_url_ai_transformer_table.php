<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transformation_results', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('type');
            $table->text('result')->nullable();

            $table->timestamp('successfully_completed_at')->nullable();

            $table->timestamp('latest_exception_seen_at')->nullable();
            $table->text('latest_exception_message')->nullable();
            $table->longText('latest_exception_trace')->nullable();

            $table->timestamps();

            $table->index('url');
        });
    }
};
