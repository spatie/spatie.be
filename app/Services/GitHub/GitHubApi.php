<?php

namespace App\Services\GitHub;

use Github\Client;
use Github\ResultPager;
use Illuminate\Support\Collection;

class GitHubApi
{
    /** @var \Github\Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchPublicRepositories(string $username): Collection
    {
        $api = $this->client->api('organization');

        $paginator = new ResultPager($this->client);

        $repositories = $paginator->fetchAll($api, 'repositories', [$username]);

        return collect($repositories)->filter(function ($repo) {
            return $repo['private'] === false;
        });
    }

    public function fetchOpenIssues(string $username, string $repository, array $labelFilters = []): Collection
    {
        $api = $this->client->api('issue');

        $paginator = new ResultPager($this->client);

        $issues = $paginator->fetchAll($api, 'all', [$username, $repository, ['state' => 'open']]);

        return collect($issues)->filter(function (array $issue) use ($labelFilters) {
            if (! $labelFilters) {
                return true;
            }

            return collect($issue['labels'] ?? [])->filter(function (array $label) use ($labelFilters) {
                return in_array($label['name'] ?? null, $labelFilters);
            })->isNotEmpty();
        });
    }

    public function fetchRepositoryTopics(string $username, string $repository): Collection
    {
        $api = $this->client->api('repository');

        return collect($api->topics($username, $repository)['names'] ?? []);
    }

    public function fetchRepositoryContributors(string $username, string $repository): Collection
    {
        $api = $this->client->api('repository');

        $paginator = new ResultPager($this->client);

        return collect($paginator->fetchAll($api, 'contributors', [$username, $repository]));
    }

    public function getUser($username)
    {
        $api = $this->client->api('user');

        return $api->show($username);
    }
}
