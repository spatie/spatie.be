<?php

namespace Database\Seeders;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    public function run(): void
    {
        /** @var Bundle $bundle */
        $bundle = Bundle::factory()->create();

        Purchasable::query()
            ->take(2)
            ->each(function (Purchasable $purchasable) use ($bundle) {
                $bundle->purchasables()->attach($purchasable->id);
            });
    }
}
