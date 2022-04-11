<?php

namespace Database\Factories;

use App\Domain\Shop\Enums\SeriesType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'test',
            'description' => 'test',
            'slug' => 'test',
            'type' => SeriesType::Video->value,
        ];
    }
}
