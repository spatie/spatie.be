<?php

namespace App\Console\Commands;

use App\Jobs\ImportDocsForRepositoryJob;
use Illuminate\Console\Command;

class ImportDocsCommand extends Command
{
    protected $signature = 'app:import-docs {repository}';

    protected $description = 'Schedule a job to import docs from a repository';

    public function handle()
    {
        $repository = $this->argument('repository');
        dispatch(new ImportDocsForRepositoryJob($repository));
    }
}
