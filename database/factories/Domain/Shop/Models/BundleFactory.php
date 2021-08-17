<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\Bundle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BundleFactory extends Factory
{
    protected $model = Bundle::class;

    public function definition()
    {
        $title = "{$this->faker->jobTitle} bundle";
        $priceInCents = $this->faker->numberBetween(100, 10000);

        return [
            'title' => $title,
            'description' => $this->faker->text,
            'long_description' => $this->faker->text,
            'slug' => Str::slug($title),
            'paddle_product_id' => (string)$this->faker->randomNumber(5),
            'price_in_usd_cents' => $priceInCents,
        ];
    }
}
