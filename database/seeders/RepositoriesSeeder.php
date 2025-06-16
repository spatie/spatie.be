<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Repository;
use Illuminate\Database\Seeder;

class RepositoriesSeeder extends Seeder
{
    public function run(): void
    {
        Repository::factory()->times(5)->create()
            ->each(function (Repository $repository): void {
                if (faker()->boolean(90)) {
                    $repository->update(['ad_id' => Ad::all()->random()->id]);
                }
            });
    }
}
