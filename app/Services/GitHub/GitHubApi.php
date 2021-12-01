<?php

namespace App\Services\GitHub;

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
        /** @var \Github\Api\Organization $api */
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
                fn(array $releaseProperties) => Carbon::create($releaseProperties['created_at'])->isBefore($onDate)
            );

        if (!$latestAvailableReleaseOnDate) {
            throw new Exception("No release found for {$repository} on date {$onDate->format('Y-m-d')}");
        }

        $featureVersionNumber = Str::beforeLast($latestAvailableReleaseOnDate['tag_name'], '.');

        $latestBugFixReleaseForFeatureVersionRelease = collect($releases)
            ->first(function (array $releaseProperties) use ($featureVersionNumber) {
                return str_starts_with($releaseProperties['tag_name'], $featureVersionNumber . '.');
            });

        return $latestBugFixReleaseForFeatureVersionRelease['tag_name'];
    }

    public function temporaryUrlOfLatestAvailableRelease(string $repository, Carbon $onDate): string
    {
        $releaseNumber = $this->latestVersionOnDate($repository, $onDate);

        $token = config('services.github.token');

        [$organisation, $repository] = explode('/', $repository);

        return Http::withHeaders([
            'Authorization' => "token {$token}"
        ])
            ->withoutRedirecting()
            ->get("https://api.github.com/repos/{$organisation}/{$repository}/zipball/{$releaseNumber}")
            ->header('Location');
    }


    public function fetchRepositoryTopics(string $username, string $repository): Collection
    {
        /** @var \Github\Api\Repo $api */
        $api = $this->client->api('repository');

        return collect($api->topics($username, $repository)['names'] ?? []);
    }

    public function fetchRepositoryContributors(string $username, string $repository): Collection
    {
        /** @var \Github\Api\Repo $api */
        $api = $this->client->api('repository');

        $paginator = new ResultPager($this->client);

        return collect($paginator->fetchAll($api, 'contributors', [$username, $repository]));
    }

    public function getUser($username)
    {
        /** @var \Github\Api\User $api */
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
