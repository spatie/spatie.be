<?php

namespace Database\Factories;

use App\Enums\PurchasableType;
use App\Models\Product;
use App\Models\Purchasable;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchasableFactory extends Factory
{
    protected $model = Purchasable::class;

    public function definition(): array
    {
        $title = "{$this->faker->jobTitle} as a service";

        return [
            'title' => $title,
            'product_id' => Product::factory(),
            'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS,
            'description' => $this->faker->text,
            'paddle_product_id' => (string)$this->faker->randomNumber(5),
            'getting_started_url' => 'https://mailcoach.app/docs',
        ];
    }
}
