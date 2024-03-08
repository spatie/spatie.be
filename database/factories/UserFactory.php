<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->firstName();

        return [
            'name' => ucfirst($name),
            'email' => "${name}@spatie.be",
            'password' => bcrypt('password'),
            'is_admin' => false,
        ];
    }
}
