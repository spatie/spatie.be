<?php

use App\Domain\Shop\Models\Purchasable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('purchasables', function (Blueprint $table) {
            $table->boolean('is_lifetime')->default(false);
        });

        Purchasable::find(18)?->update(['is_lifetime' => true]);
    }
};
