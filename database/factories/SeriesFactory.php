<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'test',
            'description' => 'test',
            'slug' => 'test',
        ];
    }
}
