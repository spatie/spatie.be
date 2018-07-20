<?php

use App\Models\Insight;
use Illuminate\Database\Seeder;

class InsightsSeeder extends Seeder
{
    public function run()
    {
        factory(Insight::class, 50)->create();
    }
}
