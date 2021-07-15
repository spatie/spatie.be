<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this
            ->call(AdSeeder::class)
            ->call(EmailListSeeder::class)
            ->call(MembersSeeder::class)
            ->call(InsightsSeeder::class)
            ->call(PlaylistSeeder::class)
            ->call(RepositoriesSeeder::class)
            ->call(ProductSeeder::class)
            ->call(UserSeeder::class)
            ->call(PurchaseSeeder::class)
            ->call(VideoSeeder::class)
            ->call(TechnologiesSeeder::class)
            ->call(AchievementSeeder::class)
            ->call(VideoSeeder::class);
    }
}
