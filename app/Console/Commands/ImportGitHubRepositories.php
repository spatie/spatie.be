<?php

namespace App\Console\Commands;

use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ImportGitHubRepositories extends Command
{
    protected $signature = 'import:github-repositories';

    protected $description = 'Import public repositories';

    /** @var \App\Services\GitHub\GitHubApi */
    protected $api;

    public function __construct(GitHubApi $api)
    {
        $this->api = $api;

        parent::__construct();
    }

    public function handle()
    {
        $this->info('Syncing all public repositories...');

        $repositories = $this->api->fetchPublicRepositories('spatie');

        $repositories->each(function (array $repositoryAttributes) {
            $this->comment("Importing `{$repositoryAttributes['name']}`... ");

            $repository = Repository::updateOrCreate(['name' => $repositoryAttributes['name'] ?? null], [
                'name' => $repositoryAttributes['name'],
                'description' => $repositoryAttributes['description'],
                'stars' => $repositoryAttributes['stargazers_count'],
                'language' => $repositoryAttributes['language'],
                'repository_created_at' => Carbon::createFromFormat(DateTime::ATOM, $repositoryAttributes['created_at']),
            ]);

            $repository->setTopics(Cache::remember("repository_topics-{$repository->name}", 3600, function () use ($repository) {
                return $this->api->fetchRepositoryTopics('spatie', $repository->name);
            }));
        });

        $this->info('All done!');
    }
}
