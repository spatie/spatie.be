<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\Referrer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferrerFactory extends Factory
{
    protected $model = Referrer::class;

    public function definition()
    {
        return [
            'slug' => $this->faker->slug,
            'discount_percentage' => $this->faker->numberBetween(1, 10),
        ];
    }
}
