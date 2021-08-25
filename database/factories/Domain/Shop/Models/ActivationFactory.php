<?php

namespace Database\Factories\Domain\Shop\Models;

use App\Domain\Shop\Models\Activation;
use App\Domain\Shop\Models\License;
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
