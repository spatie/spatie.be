<?php

namespace Database\Factories;

use App\Models\Postcard;
use Illuminate\Database\Eloquent\Factories\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class PostcardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Postcard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'sender' => ($this->faker->boolean ? '@': '') . $this->faker->userName . ($this->faker->boolean ? ', ' . $this->faker->name : ''),
        'city' => $this->faker->boolean ? $this->faker->city : '',
        'country' => $this->faker->country ? $this->faker->country : '',
    ];
    }
}
