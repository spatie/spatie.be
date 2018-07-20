<?php

use App\Models\Contributor;
use Illuminate\Database\Seeder;

class ContributorSeeder extends Seeder
{
    public function run()
    {
        factory(Contributor::class, 1)->create();
    }
}
