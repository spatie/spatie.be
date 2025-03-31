<?php

namespace App\Jobs;

use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class ImportDocsForRepositoryJob implements ShouldQueue
{
    use Queueable;

    protected Repository $repository;

    public function __construct(protected string $repositoryName)
    {
        $this->repository = Repository::query()->where('name', $this->repositoryName)->firstOrFail();
    }

    public function handle(): void
    {
        $lastVersionDate = resolve(GitHubApi::class)->getLatestVersionDate('spatie/' . $this->repositoryName);
        $lastImportDate = $this->repository->docs_synced_at;

        if ($lastImportDate && $lastImportDate->isAfter($lastVersionDate)) {
            return;
        }

        $repository = collect(config('docs.repositories'))->keyBy('repository')->get('spatie/'.$this->repositoryName);

        foreach ($repository['branches'] as $branch => $alias) {
            $this->importAlias($repository, $branch, $alias);
        }

        $this->repository->update(['docs_synced_at' => now()]);
    }

    protected function importAlias(array $repository, string $branch, string $alias): void
    {
        $accessToken = config('services.github.docs_access_token');
        $publicDocsAssetPath = public_path('docs');
        $tempPath = storage_path('docs-temp') . '/' . $repository['name'] . '/' . $alias;

        $process = Process::fromShellCommandline(
            <<<BASH
                rm -rf storage/docs/{$repository['name']}/{$alias} \
                && mkdir -p storage/docs/{$repository['name']}/{$alias} \
                && mkdir -p storage/docs-temp/{$repository['name']}/{$alias} \
                && cd storage/docs-temp/{$repository['name']}/{$alias} \
                && rm -rf .git \
                && git init \
                && git config core.sparseCheckout true \
                && echo "/docs" >> .git/info/sparse-checkout \
                && git remote add -f origin https://{$accessToken}@github.com/spatie/{$repository['name']}.git \
                && git pull origin ${branch} \
                && cp -r docs/* ../../../docs/{$repository['name']}/{$alias} \
                && echo "---\ntitle: {$repository['name']}\ncategory: {$repository['category']}\n---" > ../../../docs/{$repository['name']}/_index.md \
                && cd docs/ \
                && find . -not -name '*.md' | cpio -pdm {$publicDocsAssetPath}/{$repository['name']}/{$alias}/ \
            BASH
            ,
            base_path()
        );

        $process->run();

        File::deleteDirectory($tempPath);
    }
}
