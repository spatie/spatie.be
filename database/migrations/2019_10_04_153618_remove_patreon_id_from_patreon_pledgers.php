<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePatreonIdFromPatreonPledgers extends Migration
{
    public function up()
    {
        Schema::table('patreon_pledgers', function (Blueprint $table) {
            $table->dropColumn('patreon_id');
        });
    }
}
