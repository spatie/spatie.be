<?php

namespace Database\Factories;

use App\Domain\Achievements\Models\Achievement;
use App\Domain\Achievements\Enums\AchievementType;
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
