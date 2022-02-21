<?php

namespace Database\Factories;

use App\Models\Enums\TechnologyType;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnologyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(TechnologyType::toArray()),
            'website_url' => $this->faker->url(),
            'description' => $this->faker->realText(),
            'recommended_by' => [$this->faker->firstName()],
        ];
    }
}
