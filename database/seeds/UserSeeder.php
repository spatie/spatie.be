<?php

use App\Models\License;
use App\Models\Product;
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
        ])->map(fn (string $name) => User::create([
            'name' => ucfirst($name),
            'email' => "${name}@spatie.be",
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]))->each(function (User $user) {
            $randomProducts = Product::query()->inRandomOrder()->take(random_int(0, 5))->get();

            $this->createPurchases($user, $randomProducts);
        });
    }

    protected function createPurchases(User $user, Collection $randomProducts)
    {
        $randomProducts->each(function (Product $product) use ($user) {
            if ($product->requires_license) {
                $license = factory(License::class)->create([
                    'product_id' => $product->id,
                ]);
            }

            factory(Purchase::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'license_id' => optional($license)->id,
            ]);
        });
    }
}
