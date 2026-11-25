<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('admin_accesses', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->unique();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        DB::table('admin_accesses')
            ->join('users', 'users.email', '=', 'admin_accesses.email')
            ->where('users.is_admin', true)
            ->update(['admin_accesses.user_id' => DB::raw('users.id')]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
