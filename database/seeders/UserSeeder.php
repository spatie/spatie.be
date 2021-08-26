<?php

namespace Database\Seeders;

use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        collect(config('team.members'))->map(fn (string $name) => User::firstOrCreate([
            'email' => "${name}@spatie.be",
        ], [
            'name' => ucfirst($name),
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]))->each(function (User $user): void {
            $randomPurchasables = Purchasable::query()->inRandomOrder()->take(random_int(0, 5))->get();

            $this->createPurchases($user, $randomPurchasables);
        });
    }

    protected function createPurchases(User $user, Collection $randomPurchasables): void
    {
        $randomPurchasables->each(function (Purchasable $purchasable) use ($user): void {
            $purchase = Purchase::factory()->create([
                'user_id' => $user->id,
                'purchasable_id' => $purchasable->id,
                'paddle_fee' => 0,
                'earnings' => 0,
                'quantity' => 1,
            ]);

            $assignment = PurchaseAssignment::create([
                'purchasable_id' => $purchasable->id,
                'user_id' => $user->id,
                'purchase_id' => $purchase->id,
                'has_repository_access' => false,
            ]);

            if ($purchasable->requires_license) {
                License::factory()->create([
                    'purchase_assignment_id' => $assignment->id,
                ]);
            }
        });
    }
}
