<?php

namespace App\Console\Commands;

use App\Jobs\GeneratePackageGithubHeaderJob;
use App\Models\Repository;
use Illuminate\Console\Command;

class GeneratePackageHeaderCommand extends Command
{
    protected $signature = 'app:generate-package-header';

    protected $description = 'Command description';

    public function handle()
    {
        $repository = Repository::where('name', 'browsershot')->firstOrFail();

        dispatch(new GeneratePackageGithubHeaderJob($repository));
    }
}
