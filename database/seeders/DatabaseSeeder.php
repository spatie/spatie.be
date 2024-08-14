<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this
            ->call(SiteSearchSeeder::class)
            ->call(AdSeeder::class)
            ->call(MembersSeeder::class)
            ->call(ExternalFeedItemSeeder::class)
            ->call(PlaylistSeeder::class)
            ->call(RepositoriesSeeder::class)
            ->call(ProductSeeder::class)
            ->call(BundleSeeder::class)
            ->call(AchievementSeeder::class)
            ->call(CoursesSeeder::class)
            ->call(UserSeeder::class)
            ->call(PurchaseSeeder::class)
            ->call(TechnologiesSeeder::class);
    }
}
