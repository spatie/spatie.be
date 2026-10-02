<?php

namespace App\Console\Commands;

use App\Docs\DocsImporter;
use App\Exceptions\DocsImportException;
use App\Support\ValueStores\UpdatedRepositoriesValueStore;
use Illuminate\Console\Command;
use Throwable;

class ImportDocsFromRepositoriesCommand extends Command
{
    protected $signature = 'docs:import {--repo=} {--all}';

    protected $description = 'Fetches docs from all repositories in docs-repositories.json';

    public function handle(DocsImporter $docsImporter): void
    {
        $this->info('Importing docs...');

        $updatedRepositoriesValueStore = UpdatedRepositoriesValueStore::make();

        $updatedRepositoryNames = $updatedRepositoriesValueStore->getNames();

        if ($extraRepo = $this->option('repo')) {
            $updatedRepositoryNames[] = $extraRepo;
        }

        if ($this->option('all')) {
            $updatedRepositoryNames = collect(config('docs.repositories'))->pluck('repository')->toArray();
        }

        $repositories = collect(config('docs.repositories'))
            ->filter(fn (array $repository) => in_array($repository['repository'], $updatedRepositoryNames));

        $this->info("{$repositories->count()} repositories.");

        $repositories->each(function (array $repository) use ($docsImporter) {
            $this->info("Importing docs of {$repository['repository']}...");

            try {
                $docsImporter->import($repository);
            } catch (Throwable $exception) {
                $this->error("{$repository['name']}: {$exception->getMessage()}");

                report(new DocsImportException("Import for repository {$repository['name']} unsuccessful: {$exception->getMessage()}", previous: $exception));
            }
        });

        $updatedRepositoriesValueStore->flush();

        $this->info('All done!');
    }
}
