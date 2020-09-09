<?php

use App\Models\Contributor;
use Illuminate\Database\Seeder;

class ContributorSeeder extends Seeder
{
    public function run()
    {
        Contributor::factory()->times(1)->create();
    }
}
