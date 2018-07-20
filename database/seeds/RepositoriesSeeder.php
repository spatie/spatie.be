<?php

use App\Models\Issue;
use App\Models\Repository;
use Illuminate\Database\Seeder;

class RepositoriesSeeder extends Seeder
{
    public function run()
    {
        factory(Repository::class, 200)->create()
            ->filter(function () {
                return faker()->boolean(20);
            })
            ->each(function (Repository $repository) {
                factory(Issue::class)->create([
                   'repository_id' => $repository->id,
                ]);
            });
    }
}
