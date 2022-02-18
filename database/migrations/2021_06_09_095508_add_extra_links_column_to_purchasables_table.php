<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('purchasables', function (Blueprint $table) {
            $table->text('extra_links')->nullable();
        });
    }
};
