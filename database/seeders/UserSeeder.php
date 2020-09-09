<?php

namespace Database\Seeders;

use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UserSeeder extends Seeder
{
    public function run()
    {
        collect([
            'freek',
            'willem',
            'rias',
            'alex',
            'ruben',
        ])->map(fn (string $name) => User::create([
            'name' => ucfirst($name),
            'email' => "${name}@spatie.be",
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]))->each(function (User $user) {
            $randomPurchasables = Purchasable::query()->inRandomOrder()->take(random_int(0, 5))->get();

            //$this->createPurchases($user, $randomPurchasables);
        });
    }

    protected function createPurchases(User $user, Collection $randomPurchasables)
    {
        $randomPurchasables->each(function (Purchasable $purchase) use ($user) {
            if ($purchase->requires_license) {
                $license = License::factory()->create([
                    'purchasable_id' => $purchase->id,
                    'user_id' => $user->id,
                ]);
            }

            Purchase::factory()->create([
                'user_id' => $user->id,
                'purchasable_id' => $purchase->id,
                'license_id' => optional($license ?? null)->id,
            ]);
        });
    }
}
