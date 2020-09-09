<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PurchasableType;
use App\Models\Product;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class PurchasableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Purchasable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = "{$this->faker->jobTitle} as a service";

    return [
        'title' => $title,
        'product_id' => Product::factory(),
        'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS,
        'description' => $this->faker->text,
        'paddle_product_id' => (string) $this->faker->randomNumber(5),
    ];
    }
}
