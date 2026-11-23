<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('repositories', function (Blueprint $table) {
            $table->string('visibility')->default('staff')->index();
            $table->json('docs_branches')->nullable();
            $table->string('docs_category')->nullable();
        });

        DB::table('repositories')->update(['visibility' => 'public']);
    }
};
