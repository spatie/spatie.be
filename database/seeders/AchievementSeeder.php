<?php

namespace Database\Seeders;

use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Enums\AchievementType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        if (! file_exists(Storage::disk('public')->path('achievement.png'))) {
            Storage::disk('public')->put('achievement.png', file_get_contents(__DIR__ . '/achievement.png'));
        }

        collect([
            ['100-experience', '100 XP!', "You've earned a 100 XP points", 100],
            ['1000-experience', '1000 XP!', "You've earned a 1000 XP points", 1000],
        ])
            ->eachSpread(function (string $slug, string $title, string $description, int $requiredCount) {
                Achievement::create([
                    'slug' => $slug,
                    'title' => $title,
                    'description' => $description,
                    'type' => AchievementType::Experience(),
                    'data' => ['count_requirement' => $requiredCount],
                    'image_path' => 'achievement.png',
                    'attachment_path' => 'achievement.png',
                ]);
            });

        collect([
            ['10-pull-requests', '10 Pull Requests', "You've got ten merged pull requests!", 10,],
            ['50-pull-requests', '50 Pull Requests', "You've got fifty merged pull requests!", 50,],
            ['100-pull-requests', '100 Pull Requests', "You've got a hundred merged pull requests!", 100,],
            ['200-pull-requests', '200 Pull Requests', "You've got two hundred merged pull requests!", 200,],
        ])
            ->eachSpread(function (string $slug, string $title, string $description, int $requiredCount) {
                Achievement::create([
                    'slug' => $slug,
                    'title' => $title,
                    'description' => $description,
                    'type' => AchievementType::PullRequest(),
                    'data' => ['count_requirement' => $requiredCount],
                    'image_path' => 'achievement.png',
                    'attachment_path' => 'achievement.png',
                ]);
            });
    }
}
