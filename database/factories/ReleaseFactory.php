<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Release;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReleaseFactory extends Factory
{
    protected $model = Release::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'notes' => $this->faker->sentence,
            'released' => true,
            'version' => '0.0.1',
            'released_at' => now(),
        ];
    }
}
