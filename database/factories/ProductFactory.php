<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = "{$this->faker->jobTitle} as a service";

        return [
        'title' => $title,
        'description' => $this->faker->text,
        'url' => $this->faker->url,
        'action_url' => $this->faker->url,
        'action_label' => $this->faker->sentence(4),
        'slug' => Str::slug($title),
    ];
    }
}
