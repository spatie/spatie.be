<?php

namespace App\Services\GitHub;

use App\Services\GitHub\Exceptions\GitHubTwoFactorAuthenticationRequired;
use Exception;
use Github\Api\Organization;
use Github\Api\Repo;
use Github\Api\User;
use Github\Client;
use Github\Exception\RuntimeException;
use Github\Exception\ValidationFailedException;
use Github\ResultPager;
use Http;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Throwable;

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

    public function fetchReleases(string $repository): Collection
    {
        [$organisation, $repository] = explode('/', $repository);

        /** @var Repo $repoApi */
        $repoApi = $this->client->api('repo');

        $paginator = new ResultPager($this->client, 100);

        return collect($paginator->fetchAll($repoApi->releases(), 'all', [$organisation, $repository]));
    }

    public function fetchTags(string $repository): Collection
    {
        [$organisation, $repository] = explode('/', $repository);

        /** @var Repo $repoApi */
        $repoApi = $this->client->api('repo');

        $paginator = new ResultPager($this->client, 100);

        return collect($paginator->fetchAll($repoApi, 'tags', [$organisation, $repository]));
    }

    public function fetchCommitDate(string $repository, string $sha): Carbon
    {
        [$organisation, $repository] = explode('/', $repository);

        /** @var Repo $repoApi */
        $repoApi = $this->client->api('repo');

        $commit = $repoApi->commits()->show($organisation, $repository, $sha);

        return Carbon::parse($commit['commit']['committer']['date']);
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

    public function userExists(string $username): bool
    {
        try {
            $this->getUser($username);

            return true;
        } catch (RuntimeException $exception) {
            if ($exception->getCode() === 404) {
                return false;
            }

            throw $exception;
        }
    }

    public function getUsernameForId(int $gitHubId): ?string
    {
        /** @var User $api */
        $api = $this->client->api('user');

        try {
            return $api->showById($gitHubId)['login'];
        } catch (RuntimeException $exception) {
            if ($exception->getCode() === 404) {
                return null;
            }

            throw $exception;
        }
    }

    /**
     * @param array<int, string> $repositories
     * @return array<string, RepositoryAccessStatus>
     */
    public function repositoryAccessStatuses(string $gitHubUsername, array $repositories): array
    {
        $statuses = [];
        $uncached = [];

        foreach ($repositories as $repository) {
            $cached = Cache::get($this->repositoryAccessCacheKey($gitHubUsername, $repository));

            if ($cached) {
                $statuses[$repository] = RepositoryAccessStatus::from($cached);

                continue;
            }

            $uncached[] = $repository;
        }

        foreach ($this->fetchRepositoryAccessStatuses($gitHubUsername, $uncached) as $repository => $status) {
            Cache::put($this->repositoryAccessCacheKey($gitHubUsername, $repository), $status->value, 60);
            $statuses[$repository] = $status;
        }

        return $statuses;
    }

    /**
     * @param array<int, string> $repositories
     * @return array<string, RepositoryAccessStatus>
     */
    protected function fetchRepositoryAccessStatuses(string $gitHubUsername, array $repositories): array
    {
        $statuses = array_fill_keys($repositories, RepositoryAccessStatus::Unknown);

        if (! $repositories || blank(config('services.github.token'))) {
            return $statuses;
        }

        $urls = [];
        foreach ($repositories as $repository) {
            $urls[$repository] = "https://api.github.com/repos/{$repository}/collaborators/" . rawurlencode($gitHubUsername);
        }

        $withoutAccess = [];
        foreach ($this->repositoryAccessRequests($urls) as $repository => $response) {
            if (! $response instanceof Response) {
                continue;
            }

            if ($response->noContent()) {
                $statuses[$repository] = RepositoryAccessStatus::Granted;
            }

            if ($response->notFound()) {
                $withoutAccess[] = $repository;
            }
        }

        // Bound pagination so an unusually large invitation list cannot hold up Purchases indefinitely.
        for ($page = 1; $page <= 3 && $withoutAccess; $page++) {
            $urls = [];
            foreach ($withoutAccess as $repository) {
                $urls[$repository] = "https://api.github.com/repos/{$repository}/invitations?per_page=100&page={$page}";
            }

            $withoutAccess = [];
            foreach ($this->repositoryAccessRequests($urls) as $repository => $response) {
                if (! $response instanceof Response || ! $response->ok()) {
                    continue;
                }

                $invitations = $response->json();

                if (! is_array($invitations) || ! array_is_list($invitations)) {
                    continue;
                }

                if (collect($invitations)->contains(fn ($invitation) => strcasecmp($invitation['invitee']['login'] ?? '', $gitHubUsername) === 0)) {
                    $statuses[$repository] = RepositoryAccessStatus::Pending;

                    continue;
                }

                if (Str::contains($response->header('Link'), 'rel="next"')) {
                    $withoutAccess[] = $repository;

                    continue;
                }

                // A successful invitations request also confirms our token can see this repository.
                // A collaborator 404 alone could mean the token cannot access the private repository.
                $statuses[$repository] = RepositoryAccessStatus::Missing;
            }
        }

        return $statuses;
    }

    /**
     * @param array<string, string> $urls
     * @return array<string, Response|Throwable>
     */
    protected function repositoryAccessRequests(array $urls): array
    {
        return Http::pool(fn (Pool $pool) => collect($urls)->map(fn (string $url, string $repository) => $pool->as($repository)
            ->withToken(config('services.github.token'))
            ->withHeaders(['Accept' => 'application/vnd.github+json', 'User-Agent' => 'spatie.be'])
            ->connectTimeout(1)
            ->timeout(2)
            ->withoutRedirecting()
            ->get($url))->all());
    }

    protected function repositoryAccessCacheKey(string $gitHubUsername, string $repository): string
    {
        return 'github-repository-access:' . hash('sha256', json_encode([
            strtolower($gitHubUsername), strtolower($repository), config('services.github.token'),
        ]));
    }

    public function inviteToRepo(string $gitHubUsername, string $repository): void
    {
        Cache::forget($this->repositoryAccessCacheKey($gitHubUsername, $repository));

        [$organisation, $repository] = explode('/', $repository);

        try {
            $this->client->repo()->collaborators()->add(
                $organisation,
                $repository,
                $gitHubUsername,
                ['permission' => 'pull']
            );
        } catch (RuntimeException|ValidationFailedException $exception) {
            if (! in_array($exception->getCode(), [403, 422], true)
                || ! Str::contains(Str::lower($exception->getMessage()), ['two-factor', 'two factor', '2fa', 'mfa'])) {
                throw $exception;
            }

            throw new GitHubTwoFactorAuthenticationRequired($exception);
        }
    }

    public function revokeAccessToRepo(string $gitHubUsername, string $repository): void
    {
        Cache::forget($this->repositoryAccessCacheKey($gitHubUsername, $repository));

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
