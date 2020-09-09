<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Repository;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class RepositoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Repository::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'name' => $this->faker->word,
        'description' => $this->faker->sentence,
        'documentation_url' => $this->faker->boolean ? $this->faker->url : null,
        'blogpost_url' => $this->faker->boolean ? $this->faker->url : null,
        'topics' => $this->faker->randomElements([$this->faker->word, $this->faker->word, $this->faker->word, $this->faker->word], $this->faker->numberBetween(1, 4)),
        'stars' => $this->faker->numberBetween(0, 5000),
        'downloads' => $this->faker->numberBetween(0, 1000000),
        'new' => $this->faker->boolean(20),
        'highlighted' => $this->faker->boolean(5),
        'language' => $this->faker->randomElement(['php', 'javascript']),
        'type' => $this->faker->randomElement(\App\Models\Enums\RepositoryType::toArray()),
    ];
    }
}
