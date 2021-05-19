<?php

namespace Database\Factories;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaylistFactory extends Factory
{
    protected $model = Playlist::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'spotify_url' => $this->faker->url,
            'apple_music_url' => $this->faker->url,
        ];
    }
}
