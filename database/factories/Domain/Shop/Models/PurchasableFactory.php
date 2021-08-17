<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Enums\PurchasableType;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchasableFactory extends Factory
{
    protected $model = Purchasable::class;

    public function definition(): array
    {
        $priceInCents = $this->faker->numberBetween(100, 10000);

        return [
            'title' => "{$this->faker->jobTitle} as a service",
            'product_id' => Product::factory(),
            'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS,
            'description' => $this->faker->text,
            'paddle_product_id' => (string)$this->faker->randomNumber(5),
            'getting_started_url' => 'https://mailcoach.app/docs',
            'price_in_usd_cents' => $priceInCents,
            'released' => true,
        ];
    }
}
