<?php

namespace Database\Seeders;

use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        collect(config('team.members'))->map(fn (string $name) => User::create([
            'name' => ucfirst($name),
            'email' => "${name}@spatie.be",
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]))->each(function (User $user): void {
            $randomPurchasables = Purchasable::query()->inRandomOrder()->take(random_int(0, 5))->get();

            $this->createPurchases($user, $randomPurchasables);
        });
    }

    protected function createPurchases(User $user, Collection $randomPurchasables): void
    {
        $randomPurchasables->each(function (Purchasable $purchase) use ($user): void {
            if ($purchase->requires_license) {
                License::factory()->create([
                    'purchasable_id' => $purchase->id,
                    'user_id' => $user->id,
                ]);
            }

            Purchase::factory()->create([
                'user_id' => $user->id,
                'purchasable_id' => $purchase->id,
                'paddle_fee' => 0,
                'earnings' => 0,
                'quantity' => 1,
                'has_repository_access' => false,
            ]);
        });
    }
}
