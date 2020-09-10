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
        info('using github token fetchPublicRepositories');

        $paginator = new ResultPager($this->client);

        $repositories = $paginator->fetchAll($api, 'repositories', [$username]);

        return collect($repositories)->filter(function ($repo) {
            return $repo['private'] === false;
        });
    }

    public function fetchOpenIssues(string $username, string $repository, array $labelFilters = []): Collection
    {
        $api = $this->client->api('issue');
        info('using github token fetchOpenIssues');


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
        info('using github token fetchRepositoryTopics');

        return collect($api->topics($username, $repository)['names'] ?? []);
    }

    public function fetchRepositoryContributors(string $username, string $repository): Collection
    {
        $api = $this->client->api('repository');
        info('using github token fetchRepositoryContributors');

        $paginator = new ResultPager($this->client);

        return collect($paginator->fetchAll($api, 'contributors', [$username, $repository]));
    }

    public function getUser($username)
    {
        $api = $this->client->api('user');
        info('using github token getUser');


        return $api->show($username);
    }

    public function inviteToRepo(string $gitHubUsername, string $repository)
    {
        [$organisation, $repository] = explode('/', $repository);

        info('using github token inviteToRepo');
        $this->client->repo()->collaborators()->add(
            $organisation,
            $repository,
            $gitHubUsername,
            ['permission' => 'pull']
        );
    }

    public function revokeAccessToRepo(string $gitHubUsername, string $repository)
    {
        [$organisation, $repository] = explode('/', $repository);

        $this->client->repo()->collaborators()->remove(
            $organisation,
            $repository,
            $gitHubUsername,
        );
        info('using github token revokeAccessToRepo');
    }
}
