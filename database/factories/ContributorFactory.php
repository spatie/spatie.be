<?php

namespace Database\Factories;

use App\Models\Contributor;
use Illuminate\Database\Eloquent\Factories\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class ContributorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contributor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'name' => $this->faker->name,
        'username' => $this->faker->userName,
        'avatar_url' => $this->faker->imageUrl(),
        'repository_url' => $this->faker->url,
        'repository_name' => $this->faker->word,
    ];
    }
}
