<?php

namespace App\Console\Commands;

use App\Docs\Docs;
use App\Jobs\ImportDocsForRepositoryJob;
use Illuminate\Console\Command;

class ImportAllDocsCommand extends Command
{
    protected $signature = 'app:import-all-docs {--force : Import even if there is no new release since the last import}';

    protected $description = 'Schedule a job to import all docs from all repositories';

    public function handle(): void
    {
        $repositories = Docs::configurations()->pluck('name');

        foreach ($repositories as $repository) {
            dispatch(new ImportDocsForRepositoryJob($repository, $this->option('force')));
        }

        $this->comment("Dispatched {$repositories->count()} jobs to import docs.");
    }
}
