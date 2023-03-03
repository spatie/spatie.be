<?php

use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchase;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->unsignedBigInteger('purchase_id')->after('purchasable_id')->nullable();

            $table->foreign('purchase_id')->references('id')->on('purchases')->cascadeOnDelete();
        });

        License::each(function (License $license) {
            $purchase = Purchase::where('license_id', $license->id)->first();

            if (! $purchase) {
                return;
            }

            $license->update([
                'purchase_id' => $purchase->id,
            ]);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('purchases_license_id_foreign');
            $table->dropColumn('license_id');

            $table->integer('quantity')->default(1);
            $table->json('passthrough')->nullable();
        });
    }
};
