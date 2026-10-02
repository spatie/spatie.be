<?php

use App\Docs\Docs;
use App\Docs\DocsStorage;
use App\Jobs\ImportDocsForRepositoryJob;
use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\Docs\Support\FakeGitHubDocs;

beforeEach(function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');
    Storage::fake('github_ads');

    config()->set('docs.cache_store', 'array');
    config()->set('docs.repositories', [[
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => ['main' => 'v9'],
        'category' => 'Laravel',
    ]]);

    FakeGitHubDocs::make()->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9'));

    $this->mock(GitHubApi::class)
        ->allows('getLatestVersionDate')
        ->with('spatie/laravel-backup')
        ->andReturn(now()->subDay());
});

it('imports the docs when there is a release since the last import', function () {
    $this->freezeSecond();

    $repository = Repository::factory()->create([
        'name' => 'laravel-backup',
        'docs_synced_at' => now()->subWeek(),
    ]);

    dispatch(new ImportDocsForRepositoryJob('laravel-backup'));

    expect(app(Docs::class)->getRepository('laravel-backup')->getAlias('v9'))->not->toBeNull();
    expect($repository->refresh()->docs_synced_at->equalTo(now()))->toBeTrue();
});

it('imports the docs of a repository that was never imported', function () {
    Repository::factory()->create(['name' => 'laravel-backup', 'docs_synced_at' => null]);

    dispatch(new ImportDocsForRepositoryJob('laravel-backup'));

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-backup/branches/main');
});

it('skips the import when there was no release since the last import', function () {
    Repository::factory()->create([
        'name' => 'laravel-backup',
        'docs_synced_at' => now()->subHour(),
    ]);

    dispatch(new ImportDocsForRepositoryJob('laravel-backup'));

    Http::assertNothingSent();
});

it('can be forced to import the docs', function () {
    Repository::factory()->create([
        'name' => 'laravel-backup',
        'docs_synced_at' => now()->subHour(),
    ]);

    dispatch(new ImportDocsForRepositoryJob('laravel-backup', force: true));

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-backup/branches/main');
    expect(app(Docs::class)->getRepository('laravel-backup')->getAlias('v9'))->not->toBeNull();
});

it('can run again when it is delivered a second time', function () {
    Repository::factory()->create(['name' => 'laravel-backup']);

    $job = new ImportDocsForRepositoryJob('laravel-backup');

    expect($job->tries)->toBe(2);
    expect($job->maxExceptions)->toBe(1);
});

it('leaves the docs intact when an interrupted import runs again', function () {
    Repository::factory()->create(['name' => 'laravel-backup', 'docs_synced_at' => null]);

    dispatch(new ImportDocsForRepositoryJob('laravel-backup'));

    $previousReleasePath = app(DocsStorage::class)->currentReleasePath('laravel-backup');

    $interruptedReleasePath = app(DocsStorage::class)->createReleasePath('laravel-backup');
    Storage::disk('docs')->put("{$interruptedReleasePath}/v9/introduction.md", 'Half imported');

    dispatch(new ImportDocsForRepositoryJob('laravel-backup', force: true));

    $currentReleasePath = app(DocsStorage::class)->currentReleasePath('laravel-backup');

    expect(Storage::disk('docs')->directories('laravel-backup/releases'))
        ->toEqualCanonicalizing([$previousReleasePath, $currentReleasePath]);
    expect(Storage::disk('docs')->allFiles($currentReleasePath))
        ->toEqualCanonicalizing(collect(Storage::disk('docs')->allFiles($previousReleasePath))
            ->map(fn (string $path) => str_replace($previousReleasePath, $currentReleasePath, $path))
            ->all());
    expect(app(Docs::class)->getRepository('laravel-backup')->getAlias('v9')->pages)->not->toBeEmpty();
});
