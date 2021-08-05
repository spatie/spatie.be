<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $name = $this->faker->unique->firstName;

        return [
            'name' => ucfirst($name),
            'email' => "${name}@spatie.be",
            'password' => bcrypt('password'),
            'is_admin' => false,
        ];
    }
}
