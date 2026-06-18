<?php

namespace App\Actions;

use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ImportRepositoryReleasesAction
{
    public function __construct(private readonly GitHubApi $gitHubApi)
    {
    }

    public function execute(Repository $repository): void
    {
        $tagShas = $this->gitHubApi
            ->fetchTags($repository->full_name)
            ->mapWithKeys(fn (array $tag) => [$tag['name'] => $tag['commit']['sha']]);

        $this->importReleases($repository, $tagShas);

        $this->importTags($repository, $tagShas);
    }

    /** @param Collection<string, string> $tagShas */
    private function importReleases(Repository $repository, Collection $tagShas): void
    {
        $this->gitHubApi
            ->fetchReleases($repository->full_name)
            ->reject(fn (array $release) => $release['draft'] ?? false)
            ->each(function (array $release) use ($repository, $tagShas): void {
                $repository->releases()->updateOrCreate(['tag_name' => $release['tag_name']], [
                    'name' => $release['name'] ?? null,
                    'body' => $release['body'] ?? null,
                    'url' => $release['html_url'],
                    'commit_sha' => $tagShas->get($release['tag_name']),
                    'is_release' => true,
                    'is_prerelease' => $release['prerelease'] ?? false,
                    'released_at' => Carbon::make($release['published_at'] ?? null),
                ]);
            });
    }

    /** @param Collection<string, string> $tagShas */
    private function importTags(Repository $repository, Collection $tagShas): void
    {
        $existingTagNames = $repository->releases()->pluck('tag_name')->all();

        $tagShas
            ->reject(fn (string $sha, string $tagName) => in_array($tagName, $existingTagNames, true))
            ->each(function (string $sha, string $tagName) use ($repository): void {
                $repository->releases()->create([
                    'tag_name' => $tagName,
                    'commit_sha' => $sha,
                    'url' => "https://github.com/{$repository->full_name}/releases/tag/{$tagName}",
                    'is_release' => false,
                    'is_prerelease' => false,
                    'released_at' => $this->gitHubApi->fetchCommitDate($repository->full_name, $sha),
                ]);
            });
    }
}
