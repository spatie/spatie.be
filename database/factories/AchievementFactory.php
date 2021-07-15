<?php

namespace Database\Factories;

use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Enums\AchievementType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    public function definition()
    {
        return [
            'title' => 'test',
            'description' => 'test',
            'slug' => 'test',
            'type' => AchievementType::Series(),
            'data' => [],
        ];
    }
}
