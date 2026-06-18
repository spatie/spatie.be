<?php

use App\Actions\ImportRepositoryReleasesAction;
use App\Models\Repository;
use App\Models\RepositoryRelease;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->api = $this->mock(GitHubApi::class);
    $this->action = resolve(ImportRepositoryReleasesAction::class);

    $this->repository = Repository::factory()->create(['name' => 'laravel-backup']);
});

it('imports github releases for a repository', function () {
    $this->api->shouldReceive('fetchReleases')->with('spatie/laravel-backup')->andReturn(collect([
        [
            'tag_name' => '10.0.1',
            'name' => 'Fix a bug',
            'body' => '## What changed',
            'html_url' => 'https://github.com/spatie/laravel-backup/releases/tag/10.0.1',
            'prerelease' => false,
            'draft' => false,
            'published_at' => '2026-06-10T08:00:00Z',
            'target_commitish' => 'main',
        ],
    ]));
    $this->api->shouldReceive('fetchTags')->andReturn(collect([
        ['name' => '10.0.1', 'commit' => ['sha' => 'abc123']],
    ]));

    $this->action->execute($this->repository);

    expect($this->repository->releases)->toHaveCount(1);

    tap($this->repository->releases->first(), function (RepositoryRelease $release) {
        expect($release->tag_name)->toBe('10.0.1');
        expect($release->name)->toBe('Fix a bug');
        expect($release->body)->toBe('## What changed');
        expect($release->url)->toBe('https://github.com/spatie/laravel-backup/releases/tag/10.0.1');
        expect($release->is_release)->toBeTrue();
        expect($release->is_prerelease)->toBeFalse();
        expect($release->commit_sha)->toBe('abc123');
        expect($release->released_at->toDateTimeString())->toBe('2026-06-10 08:00:00');
    });
});

it('imports a tag without a release using the commit date', function () {
    $this->api->shouldReceive('fetchReleases')->andReturn(collect());
    $this->api->shouldReceive('fetchTags')->with('spatie/laravel-backup')->andReturn(collect([
        ['name' => '1.0.0', 'commit' => ['sha' => 'def456']],
    ]));
    $this->api->shouldReceive('fetchCommitDate')
        ->with('spatie/laravel-backup', 'def456')
        ->andReturn(Carbon::parse('2018-01-01 12:00:00'));

    $this->action->execute($this->repository);

    tap($this->repository->releases->first(), function (RepositoryRelease $release) {
        expect($release->tag_name)->toBe('1.0.0');
        expect($release->is_release)->toBeFalse();
        expect($release->name)->toBeNull();
        expect($release->commit_sha)->toBe('def456');
        expect($release->released_at->toDateTimeString())->toBe('2018-01-01 12:00:00');
    });
});

it('skips draft releases', function () {
    $this->api->shouldReceive('fetchReleases')->andReturn(collect([
        [
            'tag_name' => '10.0.2',
            'name' => 'Unreleased',
            'body' => '',
            'html_url' => 'https://github.com/spatie/laravel-backup/releases/tag/10.0.2',
            'prerelease' => false,
            'draft' => true,
            'published_at' => null,
            'target_commitish' => 'main',
        ],
    ]));
    $this->api->shouldReceive('fetchTags')->andReturn(collect());

    $this->action->execute($this->repository);

    expect($this->repository->releases)->toHaveCount(0);
});

it('does not create a tag-only row when a release already covers the tag', function () {
    $this->api->shouldReceive('fetchReleases')->andReturn(collect([
        [
            'tag_name' => '10.0.1',
            'name' => 'Fix a bug',
            'body' => 'notes',
            'html_url' => 'https://github.com/spatie/laravel-backup/releases/tag/10.0.1',
            'prerelease' => false,
            'draft' => false,
            'published_at' => '2026-06-10T08:00:00Z',
            'target_commitish' => 'main',
        ],
    ]));
    $this->api->shouldReceive('fetchTags')->andReturn(collect([
        ['name' => '10.0.1', 'commit' => ['sha' => 'abc123']],
    ]));
    $this->api->shouldNotReceive('fetchCommitDate');

    $this->action->execute($this->repository);

    expect($this->repository->releases)->toHaveCount(1);
});

it('is idempotent when run twice', function () {
    $releases = collect([
        [
            'tag_name' => '10.0.1',
            'name' => 'Fix a bug',
            'body' => 'notes',
            'html_url' => 'https://github.com/spatie/laravel-backup/releases/tag/10.0.1',
            'prerelease' => false,
            'draft' => false,
            'published_at' => '2026-06-10T08:00:00Z',
            'target_commitish' => 'main',
        ],
    ]);

    $this->api->shouldReceive('fetchReleases')->andReturn($releases);
    $this->api->shouldReceive('fetchTags')->andReturn(collect([
        ['name' => '10.0.1', 'commit' => ['sha' => 'abc123']],
    ]));

    $this->action->execute($this->repository);
    $this->action->execute($this->repository);

    expect(RepositoryRelease::where('repository_id', $this->repository->id)->count())->toBe(1);
});
