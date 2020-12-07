<?php

namespace Database\Factories;

use App\Models\Referrer;
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
