<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this
            ->call(AdSeeder::class)
            ->call(EmailListSeeder::class)
            ->call(MembersSeeder::class)
            ->call(InsightsSeeder::class)
            ->call(RepositoriesSeeder::class)
            ->call(ProductSeeder::class)
            ->call(UserSeeder::class)
            ->call(VideoSeeder::class);
    }
}
