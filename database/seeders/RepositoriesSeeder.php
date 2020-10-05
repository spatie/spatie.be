<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Issue;
use App\Models\Repository;
use Illuminate\Database\Seeder;

class RepositoriesSeeder extends Seeder
{
    public function run()
    {
        Repository::factory()->times(200)->create()
            ->each(function (Repository $repository) {
                if (faker()->boolean(90)) {
                    $repository->update(['ad_id' => Ad::all()->random()->id]);
                }
            });
    }
}
