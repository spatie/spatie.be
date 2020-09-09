<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->firstName;

        return [
        'name' => ucfirst($name),
        'email' => "${name}@spatie.be",
        'password' => bcrypt('password'),
        'is_admin' => false,
    ];
    }
}
