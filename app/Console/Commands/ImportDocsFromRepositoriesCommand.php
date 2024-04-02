<?php

namespace App\Console\Commands;

use App\Docs\Docs;
use App\Exceptions\DocsImportException;
use App\Support\ValueStores\UpdatedRepositoriesValueStore;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Spatie\Fork\Fork;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class ImportDocsFromRepositoriesCommand extends Command
{
    protected $signature = 'docs:import {--repo=} {--all}';

    protected $description = 'Fetches docs from all repositories in docs-repositories.json';

    public function handle(): void
    {
        $this->info('Importing docs...');

        $updatedRepositoriesValueStore = UpdatedRepositoriesValueStore::make();

        $updatedRepositoryNames = $updatedRepositoriesValueStore->getNames();

        if ($extraRepo = $this->option('repo')) {
            $updatedRepositoryNames[] = $extraRepo;
        }

        $this->cleanRepositoryFolders();

        if ($this->option('all')) {
            $updatedRepositoryNames = collect(config('docs.repositories'))
                ->map(function (array $repository) {
                    return $repository['repository'];
                })
                ->toArray();
        }

        $this->info(count($updatedRepositoryNames) . ' repositories.');

        $callables = $this->convertRepositoriesToCallables($updatedRepositoryNames);

        $this->getOutput()->progressStart(count($callables));

        Fork::new()
            ->after(parent: fn () => $this->getOutput()->progressAdvance())
            ->concurrent(4)
            ->run(...$callables);

        $this->getOutput()->progressFinish();

        $this->info('Fetched & cached docs from all repositories.');

        $updatedRepositoriesValueStore->flush();

        File::deleteDirectory(storage_path('docs-temp'));

        $this->info('All done!');
    }

    protected function convertRepositoriesToCallables(
        array $updatedRepositoryNames
    ): array {
        $repositoriesWithDocs = $this->getRepositoriesWithDocs();

        return collect($updatedRepositoryNames)
            ->map(fn (string $repositoryName) => $repositoriesWithDocs[$repositoryName] ?? null)
            ->filter()
            ->flatMap(function (array $repository) {
                return collect($repository['branches'])
                    ->map(fn (string $alias, string $branch) => [$repository, $alias, $branch])
                    ->values()
                    ->toArray();
            })
            ->mapSpread(function (array $repository, string $alias, string $branch) {
                $process = $this->createProcessComponent($repository, $branch, $alias);

                $this->info("Created import process for {$repository['name']} {$branch}");

                return function () use ($process, $repository) {
                    $process->run();

                    if (! $process->isSuccessful()) {
                        $this->error($repository['name'] . ': ' . $process->getErrorOutput());
                        report(new DocsImportException("Import for repository {$repository['name']} unsuccessful: " . $process->getErrorOutput()));
                    }
                };
            })
            ->toArray();
    }

    protected function getRepositoriesWithDocs(): Collection
    {
        return collect(config('docs.repositories'))->keyBy('repository');
    }

    protected function createProcessComponent(array $repository, string $branch, string $alias): Process
    {
        $accessToken = config('services.github.docs_access_token');
        $publicDocsAssetPath = public_path('docs');

        return Process::fromShellCommandline(
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
                && find . -not -name '*.md' | cpio -pdm {$publicDocsAssetPath}/{$repository['name']}/{$alias}/
            BASH
            ,
            base_path()
        );
    }

    private function cleanRepositoryFolders(): void
    {
        $publicDocsPath = public_path('docs');
        $storageDocsPath = storage_path('docs');

        File::ensureDirectoryExists($publicDocsPath);
        File::ensureDirectoryExists($storageDocsPath);

        $directoriesToKeep = collect(config('docs.repositories'))->pluck('name');

        $finder = new Finder();
        $directories = $finder->in([$storageDocsPath, $publicDocsPath])->depth(0)->directories();

        foreach ($directories as $directory) {
            if (! $directoriesToKeep->contains($directory->getFilename())) {
                File::deleteDirectory($directory->getRealPath());
            }
        }
    }
}
