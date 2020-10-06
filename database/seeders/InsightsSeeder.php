<?php

namespace Database\Seeders;

use App\Models\Insight;
use Illuminate\Database\Seeder;

class InsightsSeeder extends Seeder
{
    public function run(): void
    {
        Insight::factory()->times(50)->create();
    }
}
