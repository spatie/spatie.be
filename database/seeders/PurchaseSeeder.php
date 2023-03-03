<?php

namespace Database\Seeders;

use App\Domain\Shop\Actions\CreateActivationAction;
use App\Domain\Shop\Actions\CreateLicenseAction;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        User::each(function (User $user) {
            /** @var \App\Domain\Shop\Models\Purchasable $purchasable */
            $purchasable = Purchasable::firstWhere('title', 'Ray license');

            $purchase = $user->purchases()->create([
                'purchasable_id' => $purchasable->id,
                'paddle_fee' => 0,
                'earnings' => 0,
            ]);

            $assignment = PurchaseAssignment::create([
                'purchasable_id' => $purchasable->id,
                'purchase_id' => $purchase->id,
                'user_id' => $user->id,
            ]);

            $license = (new CreateLicenseAction())->execute($assignment);

            (new CreateActivationAction())->execute('home', $license);
            (new CreateActivationAction())->execute('office', $license);
        });
    }
}
