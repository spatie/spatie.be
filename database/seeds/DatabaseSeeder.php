<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this
            ->call(MembersSeeder::class)
            ->call(InsightsSeeder::class)
            ->call(RepositoriesSeeder::class)
            ->call(UserSeeder::class)
            ->call(ContributorSeeder::class)
            ->call(PostcardsSeeder::class)
            ->call(InstagramPhotosSeeder::class);
    }
}
