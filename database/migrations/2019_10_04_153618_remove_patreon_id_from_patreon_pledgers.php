<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePatreonIdFromPatreonPledgers extends Migration
{
    public function up()
    {
        Schema::table('patreon_pledgers', function (Blueprint $table) {
            $table->dropColumn('patreon_id');
        });
    }
}
