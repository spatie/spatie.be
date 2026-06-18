<?php

namespace App\Console\Commands;

use App\Actions\ImportRepositoryReleasesAction;
use App\Models\Repository;
use Illuminate\Console\Command;
use Throwable;

class ImportGitHubReleasesCommand extends Command
{
    protected $signature = 'import:github-releases';

    protected $description = 'Import releases and tags for all package repositories';

    public function handle(ImportRepositoryReleasesAction $importRepositoryReleasesAction): void
    {
        $repositories = Repository::packages()->get();

        $repositories->each(function (Repository $repository) use ($importRepositoryReleasesAction): void {
            $this->info("Importing releases for `{$repository->name}`...");

            try {
                $importRepositoryReleasesAction->execute($repository);
            } catch (Throwable $exception) {
                report($exception);

                $this->error("Failed to import releases for `{$repository->name}`: {$exception->getMessage()}");
            }
        });

        $this->comment("Imported releases for {$repositories->count()} packages.");
    }
}
