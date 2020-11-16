<?php

namespace Database\Factories;

use App\Models\Activation;
use App\Models\License;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivationFactory extends Factory
{
    protected $model = Activation::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'license_id' => License::factory(),
        ];
    }
}
