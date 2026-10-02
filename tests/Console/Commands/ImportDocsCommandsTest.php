<?php

use App\Docs\Docs;
use App\Jobs\ImportDocsForRepositoryJob;
use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use App\Support\ValueStores\UpdatedRepositoriesValueStore;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\Docs\Support\FakeGitHubDocs;

beforeEach(function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');
    Storage::fake('github_ads');

    config()->set('docs.cache_store', 'array');
    config()->set('docs.repositories', [
        [
            'name' => 'laravel-backup',
            'repository' => 'spatie/laravel-backup',
            'branches' => ['main' => 'v9'],
            'category' => 'Laravel',
        ],
        [
            'name' => 'laravel-medialibrary',
            'repository' => 'spatie/laravel-medialibrary',
            'branches' => ['main' => 'v11'],
            'category' => 'Laravel',
        ],
    ]);

    $this->gitHub = FakeGitHubDocs::make()
        ->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9'))
        ->branch('spatie/laravel-medialibrary', 'main', FakeGitHubDocs::docsForVersion('v11'));
});

it('imports the docs of the given repository', function () {
    $this->artisan('docs:import', ['--repo' => 'spatie/laravel-backup'])->assertSuccessful();

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-backup/branches/main');
    expect(app(Docs::class)->getRepository('laravel-backup')->getAlias('v9'))->not->toBeNull();
    expect(app(Docs::class)->getRepository('laravel-medialibrary')->aliases)->toBeEmpty();
});

it('imports the docs of the repositories that were updated through the webhook', function () {
    UpdatedRepositoriesValueStore::make()->store('spatie/laravel-medialibrary');

    $this->artisan('docs:import')->assertSuccessful();

    Http::assertSent(fn (Request $request) => str_contains($request->url(), 'spatie/laravel-medialibrary/branches/main'));
    expect(UpdatedRepositoriesValueStore::make()->getNames())->toBeEmpty();
});

it('imports the docs of all repositories', function () {
    $this->artisan('docs:import', ['--all' => true])->assertSuccessful();

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-backup/branches/main');
    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-medialibrary/branches/main');
});

it('continues with the other repositories when an import fails', function () {
    $this->gitHub->failingBranch('spatie/laravel-backup', 'main');

    $this->artisan('docs:import', ['--all' => true])->assertSuccessful();

    expect(app(Docs::class)->getRepository('laravel-medialibrary')->getAlias('v11'))->not->toBeNull();
});

it('dispatches a job for every repository', function () {
    Queue::fake();

    Repository::factory()->create(['name' => 'laravel-backup']);
    Repository::factory()->create(['name' => 'laravel-medialibrary']);

    $this->artisan('app:import-all-docs')->assertSuccessful();

    Queue::assertPushed(ImportDocsForRepositoryJob::class, 2);
});

it('can force the import of all repositories', function () {
    $this->mock(GitHubApi::class)->shouldNotReceive('getLatestVersionDate');

    Repository::factory()->create(['name' => 'laravel-backup', 'docs_synced_at' => now()]);
    Repository::factory()->create(['name' => 'laravel-medialibrary', 'docs_synced_at' => now()]);

    $this->artisan('app:import-all-docs', ['--force' => true])->assertSuccessful();

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-backup/branches/main');
    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-medialibrary/branches/main');
});

it('can force the import of a single repository', function () {
    $this->mock(GitHubApi::class)->shouldNotReceive('getLatestVersionDate');

    Repository::factory()->create(['name' => 'laravel-backup', 'docs_synced_at' => now()]);

    $this->artisan('app:import-docs', ['repository' => 'laravel-backup', '--force' => true])->assertSuccessful();

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-backup/branches/main');
});
