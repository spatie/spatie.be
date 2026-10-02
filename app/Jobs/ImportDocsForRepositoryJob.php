<?php

namespace App\Jobs;

use App\Docs\DocsImporter;
use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class ImportDocsForRepositoryJob implements ShouldQueue
{
    use Queueable;

    protected Repository $repository;

    public function __construct(
        protected string $repositoryName,
        protected bool $force = false,
    ) {
        $this->repository = Repository::query()->where('name', $this->repositoryName)->firstOrFail();
    }

    /** @return array<int, object> */
    public function middleware(): array
    {
        return [
            (new WithoutOverlapping("import-docs-{$this->repositoryName}"))->dontRelease()->expireAfter(60 * 15),
        ];
    }

    public function handle(GitHubApi $gitHubApi, DocsImporter $docsImporter): void
    {
        if (! $this->force) {
            $lastVersionDate = $gitHubApi->getLatestVersionDate('spatie/' . $this->repositoryName);
            $lastImportDate = $this->repository->docs_synced_at;

            if ($lastImportDate && $lastImportDate->isAfter($lastVersionDate)) {
                return;
            }
        }

        $repository = collect(config('docs.repositories'))->keyBy('repository')->get('spatie/' . $this->repositoryName);

        $docsImporter->import($repository);

        $this->repository->update(['docs_synced_at' => now()]);
    }
}
