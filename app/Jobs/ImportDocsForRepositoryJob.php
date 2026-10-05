<?php

namespace App\Jobs;

use App\Docs\DocsImporter;
use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportDocsForRepositoryJob implements ShouldQueue
{
    use Queueable;

    /**
     * A deploy on Laravel Cloud can replace the queue worker while an import is running,
     * after which the job is delivered again while the import lock of the killed run is
     * still held. That delivery is released until the lock expires and the third attempt
     * runs the import. An import that throws still fails right away.
     */
    public int $tries = 3;

    public int $maxExceptions = 1;

    protected Repository $repository;

    public function __construct(
        protected string $repositoryName,
        protected bool $force = false,
    ) {
        $this->repository = Repository::query()->where('name', $this->repositoryName)->firstOrFail();
    }

    public function handle(GitHubApi $gitHubApi, DocsImporter $docsImporter): void
    {
        $fullRepositoryName = "spatie/{$this->repositoryName}";

        if (! $this->force) {
            $lastVersionDate = $gitHubApi->getLatestVersionDate($fullRepositoryName);
            $lastImportDate = $this->repository->docs_synced_at;

            if ($lastImportDate && $lastImportDate->isAfter($lastVersionDate)) {
                return;
            }
        }

        $repository = collect(config('docs.repositories'))->keyBy('repository')->get($fullRepositoryName);

        if (! $docsImporter->importUnlessAlreadyImporting($repository)) {
            $this->release(DocsImporter::LOCK_SECONDS);

            return;
        }

        $this->repository->update(['docs_synced_at' => now()]);
    }
}
