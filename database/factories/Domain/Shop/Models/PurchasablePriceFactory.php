<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchasablePrice;
use App\Support\Paddle\PaddleCountries;
use App\Support\Paddle\PaddleCurrencies;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchasablePriceFactory extends Factory
{
    protected $model = PurchasablePrice::class;

    public function definition(): array
    {
        return [
            'purchasable_id' => Purchasable::factory(),
            'country_code' => PaddleCountries::get()->random(),
            'currency_code' => PaddleCurrencies::get()->random(),
            'amount' => $this->faker->numberBetween(100, 10000),
            'overridden' => 0,
        ];
    }
}
