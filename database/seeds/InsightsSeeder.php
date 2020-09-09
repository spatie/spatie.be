<?php

use App\Models\Insight;
use Illuminate\Database\Seeder;

class InsightsSeeder extends Seeder
{
    public function run()
    {
        Insight::factory()->times(50)->create();
    }
}
