<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->firstName();

        return [
            'first_name' => ucfirst($name),
            'last_name' => $this->faker->lastName(),
            'email' => "${name}@spatie.be",
            'description' => '',
            'role' => 'Backend Developer',
        ];
    }
}
