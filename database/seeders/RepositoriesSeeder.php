<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Models\Repository;
use Illuminate\Database\Seeder;

class RepositoriesSeeder extends Seeder
{
    public function run()
    {
        Repository::factory()->times(200)->create()
            ->filter(function () {
                return faker()->boolean(20);
            })
            ->each(function (Repository $repository) {
                Issue::factory()->create([
                   'repository_id' => $repository->id,
                ]);
            });
    }
}
