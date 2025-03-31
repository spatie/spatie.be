<?php

namespace App\Console\Commands;

use App\Jobs\ImportDocsForRepositoryJob;
use Illuminate\Console\Command;

class ImportAllDocsCommand extends Command
{
    protected $signature = 'app:import-all-docs';

    protected $description = 'Schedule a job to import all docs from all repositories';

    public function handle()
    {
        $repositories = collect(config('docs.repositories'))->pluck('name');

        foreach ($repositories as $repository) {
            dispatch(new ImportDocsForRepositoryJob($repository));
        }
    }
}
