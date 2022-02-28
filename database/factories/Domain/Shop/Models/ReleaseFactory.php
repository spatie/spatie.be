<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Release;
use Illuminate\Database\Eloquent\Factories\Factory;
use function now;

class ReleaseFactory extends Factory
{
    protected $model = Release::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'notes' => $this->faker->sentence(),
            'released' => true,
            'version' => '0.0.1',
            'released_at' => now(),
        ];
    }
}
