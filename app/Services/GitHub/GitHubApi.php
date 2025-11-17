<?php

namespace App\Services\GitHub;

use Github\Api\Organization;
use Github\Api\Repo;
use Github\Api\User;
use Exception;
use Github\Client;
use Github\ResultPager;
use Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GitHubApi
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchPublicRepositories(string $username): Collection
    {
        /** @var Organization $api */
        $api = $this->client->api('organization');

        $paginator = new ResultPager($this->client);

        $repositories = $paginator->fetchAll($api, 'repositories', [$username]);

        return collect($repositories)->filter(function ($repo): bool {
            return $repo['private'] === false;
        });
    }

    public function latestVersionOnDate(string $repository, Carbon $onDate): string
    {
        [$organisation, $repository] = explode('/', $repository);

        $api = $this->client->api('repo')->releases();

        $paginator = new ResultPager($this->client);

        $releases = $paginator->fetchAll($api, 'all', [$organisation, $repository]);

        $latestAvailableReleaseOnDate = collect($releases)
            ->first(
                fn (array $releaseProperties) => Carbon::create($releaseProperties['created_at'])->isBefore($onDate)
            );

        if (! $latestAvailableReleaseOnDate) {
            throw new Exception("No release found for {$repository} on date {$onDate->format('Y-m-d')}");
        }

        $featureVersionNumber = Str::beforeLast($latestAvailableReleaseOnDate['tag_name'], '.');

        $latestBugFixReleaseForFeatureVersionRelease = collect($releases)
            ->first(function (array $releaseProperties) use ($featureVersionNumber) {
                return str_starts_with($releaseProperties['tag_name'], $featureVersionNumber . '.');
            });

        return $latestBugFixReleaseForFeatureVersionRelease['tag_name'];
    }

    public function getLatestVersionDate(string $repository)
    {
        [$organisation, $repository] = explode('/', $repository);

        $api = $this->client->api('repo')->releases();

        $paginator = new ResultPager($this->client, 5);

        $releases = $paginator->fetch($api, 'all', [$organisation, $repository]);

        return Carbon::parse($releases[0]['published_at']);
    }

    public function temporaryUrlOfLatestAvailableRelease(string $repository, Carbon $onDate): string
    {
        $releaseNumber = $this->latestVersionOnDate($repository, $onDate);

        $token = config('services.github.token');

        [$organisation, $repository] = explode('/', $repository);

        return Http::withHeaders([
            'Authorization' => "token {$token}",
        ])
            ->withoutRedirecting()
            ->get("https://api.github.com/repos/{$organisation}/{$repository}/zipball/{$releaseNumber}")
            ->header('Location');
    }

    public function fetchRepositoryTopics(string $username, string $repository): Collection
    {
        /** @var Repo $api */
        $api = $this->client->api('repository');

        return collect($api->topics($username, $repository)['names'] ?? []);
    }

    public function fetchRepositoryContributors(string $username, string $repository): Collection
    {
        /** @var Repo $api */
        $api = $this->client->api('repository');

        $paginator = new ResultPager($this->client);

        return collect($paginator->fetchAll($api, 'contributors', [$username, $repository]));
    }

    public function getUser($username)
    {
        /** @var User $api */
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

    /**
     *
     * @return array{ResultPager, array}
     */
    public function search(string $searchString, array $parameters = []): array
    {
        $searchApi = $this->client->api('search');

        $paginator = new ResultPager($this->client, 100);
        $parameters = array_merge([
            'q' => $searchString,
        ], $parameters);
        $result = $paginator->fetch($searchApi, 'code', $parameters);

        return [$paginator, $result];
    }

    /**
     *
     * @return array{ResultPager, array}
     */
    public function searchIssues(string $searchString, array $parameters = []): array
    {
        $searchApi = $this->client->api('search');

        $paginator = new ResultPager($this->client, 100);
        $parameters = array_merge([
            'q' => $searchString,
        ], $parameters);
        $result = $paginator->fetch($searchApi, 'issues', $parameters);

        return [$paginator, $result];
    }
}
