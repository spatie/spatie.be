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
            ->call(BundleSeeder::class)
            ->call(AchievementSeeder::class)
            ->call(UserSeeder::class)
            ->call(PurchaseSeeder::class)
            ->call(CoursesSeeder::class)
            ->call(TechnologiesSeeder::class);
    }
}
