<?php

use App\Models\PatreonPledger;
use Illuminate\Database\Seeder;

class PatreonPledgersSeeder extends Seeder
{
    public function run()
    {
        factory(PatreonPledger::class, 10)->create();
    }
}
