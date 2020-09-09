<?php

namespace Database\Factories;

use App\Models\Insight;
use Illuminate\Database\Eloquent\Factories\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class InsightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Insight::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'title' => $this->faker->sentence,
        'url' => $this->faker->url,
    ];
    }
}
