<?php

namespace Database\Factories;

use App\Models\Postcard;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostcardFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sender' => ($this->faker->boolean() ? '@' : '') . $this->faker->userName() . ($this->faker->boolean() ? ', ' . $this->faker->name() : ''),
            'city' => $this->faker->boolean() ? $this->faker->city() : '',
            'country' => $this->faker->country() ? $this->faker->country() : '',
        ];
    }
}
