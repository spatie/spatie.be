<?php

namespace App\Console\Commands;

use App\Jobs\ImportDocsForRepositoryJob;
use Illuminate\Console\Command;

class ImportDocsCommand extends Command
{
    protected $signature = 'app:import-docs {repository} {--force : Import even if there is no new release since the last import}';

    protected $description = 'Schedule a job to import docs from a repository';

    public function handle(): void
    {
        $repository = $this->argument('repository');

        dispatch(new ImportDocsForRepositoryJob($repository, $this->option('force')));

        $this->comment("Dispatched a job to import the docs of {$repository}.");
    }
}
