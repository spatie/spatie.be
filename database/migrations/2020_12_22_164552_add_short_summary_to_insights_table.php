<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShortSummaryToInsightsTable extends Migration
{
    public function up(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->text('short_summary');
        });
    }
}
