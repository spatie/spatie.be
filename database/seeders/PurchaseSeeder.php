<?php

namespace Database\Seeders;

use App\Domain\Shop\Actions\CreateActivationAction;
use App\Domain\Shop\Actions\CreateLicenseAction;
use App\Domain\Shop\Models\Purchasable;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        User::each(function (User $user) {
            /** @var \App\Domain\Shop\Models\Purchasable $purchasable */
            $purchase = $user->purchases()->create([
                'purchasable_id' => Purchasable::firstWhere('title', 'Timber')->id,
                'paddle_fee' => 0,
                'earnings' => 0,
            ]);

            $license = (new CreateLicenseAction())->execute($user, $purchase);

            (new CreateActivationAction())->execute('home', $license);
            (new CreateActivationAction())->execute('office', $license);
        });
    }
}
