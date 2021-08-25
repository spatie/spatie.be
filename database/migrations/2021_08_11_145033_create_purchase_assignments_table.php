<?php

use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Purchase::class)->references('id')->on('purchases')->cascadeOnDelete();
            $table->foreignIdFor(Purchasable::class)->references('id')->on('purchasables')->cascadeOnDelete();
            $table->unsignedInteger('user_id');
            $table->boolean('has_repository_access')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('licenses', function (Blueprint $table) {
            $table->foreignIdFor(PurchaseAssignment::class)->after('id');
        });

        Purchase::query()
            ->with(['purchasable', 'bundle.purchasables'])
            ->each(function (Purchase $purchase) {
                foreach ($purchase->getPurchasables() as $purchasable) {
                    $assignment = PurchaseAssignment::create([
                        'purchase_id' => $purchase->id,
                        'purchasable_id' => $purchasable->id,
                        'user_id' => $purchase->user_id,
                        'has_repository_access' => $purchase->has_repository_access,
                    ]);

                    License::query()
                        ->where('user_id', $purchase->user_id)
                        ->where('purchasable_id', $purchasable->id)
                        ->where('purchase_id', $purchase->id)
                        ->update([
                            'purchase_assignment_id' => $assignment->id,
                        ]);
                }
            });

        Schema::table('licenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('purchasable_id');
            $table->dropConstrainedForeignId('purchase_id');
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['has_repository_access']);
        });
    }
};
