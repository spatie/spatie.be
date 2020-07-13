<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use React\ChildProcess\Process;
use React\EventLoop\Factory;
use function React\Promise\all;
use function WyriHaximus\React\childProcessPromise;

class ImportDocsFromRepositoriesCommand extends Command
{
    protected $signature = 'docs:import';

    protected $description = 'Fetches docs from all repositories in docs-repositories.json';

    public function handle()
    {
        $loop = Factory::create();

        $repositories = $this->getRepositories();

        $accessToken = env('GITHUB_ACCESS_TOKEN');

        $processes = [];

        foreach ($repositories as $repository) {
            foreach ($repository['branches'] as $branch => $alias) {
                $process = new Process(<<<BASH
                    mkdir -p storage/docs/{$repository['name']}/{$alias} \
                    && mkdir -p storage/temp/{$repository['name']}/{$alias} \
                    && cd storage/temp/{$repository['name']}/{$alias} \
                    && git init \
                    && git config core.sparseCheckout true \
                    && echo "/docs" >> .git/info/sparse-checkout \
                    && git remote add -f origin https://{$accessToken}@github.com/spatie/{$repository['name']}.git \
                    && git pull origin ${branch} \
                    && cp -r docs/* ../../../docs/{$repository['name']}/{$alias} \
                    && echo "---\ntitle: {$repository['name']}\ncategory: {$repository['category']}\n---" > ../../../docs/{$repository['name']}/_index.md
                BASH);

                $processes[] = childProcessPromise($loop, $process);
            }
        }

        all($processes)->then(function ($output) {
            dump($output);
        });

        $loop->run();
    }

    private function getRepositories(): array
    {
        $repositories = [
            [
                "name" => "laravel-backup",
                "repository" => "spatie/laravel-backup",
                "branches" => [
                    "master" => "v6",
                    "v5" => "v5",
                    "v4" => "v4",
                    "v3" => "v3",
                ],
                "category" => "Laravel",
            ],
            [
                "name" => "laravel-medialibrary",
                "repository" => "spatie/laravel-medialibrary",
                "branches" => [
                    "master" => "v8",
                    "v7" => "v7",
                    "v6" => "v6",
                    "v5" => "v5",
                    "v4" => "v4",
                    "v3" => "v3",
                ],
                "category" => "Laravel",
            ],
        ];

        return $repositories;
    }
}
