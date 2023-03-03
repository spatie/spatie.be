<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\BundlePrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class BundlePriceFactory extends Factory
{
    protected $model = BundlePrice::class;

    public function definition(): array
    {
        return [
            'bundle_id' => Bundle::factory(),
            'country_code' => $this->faker->countryCode(),
            'currency_code' => $this->faker->currencyCode(),
            'amount' => $this->faker->numberBetween(1000, 100000),
            'overridden' => false,
            'currency_symbol' => '$',
        ];
    }
}
