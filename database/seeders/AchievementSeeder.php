<?php

namespace Database\Seeders;

use App\Domain\Achievements\Enums\AchievementType;
use App\Domain\Achievements\Models\Achievement;
use App\Domain\Achievements\States\ExperienceAchievementType;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        Achievement::create([
            'slug' => '100-experience',
            'title' => '100 XP!',
            'description' => "You've earned a 100 XP points!",
            'type' => ExperienceAchievementType::class,
            'data' => ['count_requirement' => 100],
        ]);

        Achievement::create([
            'slug' => '1000-experience',
            'title' => '1000 XP!',
            'description' => "You've earned a 1000 XP points!",
            'type' => ExperienceAchievementType::class,
            'data' => ['count_requirement' => 1000],
        ]);
    }
}
