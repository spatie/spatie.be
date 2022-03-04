<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vimeo_id' => 'test',
            'runtime' => 1,
            'thumbnail' => 'test',
            'hash' => 'test',
        ];
    }
}
