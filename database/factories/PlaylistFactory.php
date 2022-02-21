<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlaylistFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'spotify_url' => $this->faker->url(),
            'apple_music_url' => $this->faker->url(),
        ];
    }
}
