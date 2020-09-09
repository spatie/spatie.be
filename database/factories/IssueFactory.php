<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Issue;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class IssueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Issue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'repository_id' => function () {
            return Issue::factory()->create()->id;
        },
        'number' => $this->faker->numberBetween(1, 1000),
        'title' => $this->faker->sentence,
        'url' => $this->faker->url,

    ];
    }
}
