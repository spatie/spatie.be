<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this
            ->call(EmailListSeeder::class)
            ->call(MembersSeeder::class)
            ->call(InsightsSeeder::class)
            ->call(RepositoriesSeeder::class)
            ->call(ProductSeeder::class)
            ->call(UserSeeder::class)
            ->call(ContributorSeeder::class)
            ->call(VideoSeeder::class);
    }
}
