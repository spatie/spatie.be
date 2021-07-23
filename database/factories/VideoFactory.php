<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        return [
            'title' => 'test',
            'vimeo_id' => 'test',
            'slug' => 'test',
            'runtime' => 1,
            'thumbnail' => 'test',
            'sort_order' => 1,
        ];
    }
}
