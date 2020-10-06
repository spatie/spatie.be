<?php

namespace App\Services\GitHub;

use Github\Client;
use Github\ResultPager;
use Illuminate\Support\Collection;

class GitHubApi
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchPublicRepositories(string $username): Collection
    {
        $api = $this->client->api('organization');

        $paginator = new ResultPager($this->client);

        $repositories = $paginator->fetchAll($api, 'repositories', [$username]);

        return collect($repositories)->filter(function ($repo): bool {
            return $repo['private'] === false;
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

    public function inviteToRepo(string $gitHubUsername, string $repository): void
    {
        [$organisation, $repository] = explode('/', $repository);

        $this->client->repo()->collaborators()->add(
            $organisation,
            $repository,
            $gitHubUsername,
            ['permission' => 'pull']
        );
    }

    public function revokeAccessToRepo(string $gitHubUsername, string $repository): void
    {
        [$organisation, $repository] = explode('/', $repository);

        $this->client->repo()->collaborators()->remove(
            $organisation,
            $repository,
            $gitHubUsername,
        );
    }
}
