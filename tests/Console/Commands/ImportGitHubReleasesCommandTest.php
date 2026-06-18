<?php

use App\Actions\ImportRepositoryReleasesAction;
use App\Console\Commands\ImportGitHubReleasesCommand;
use App\Models\Enums\RepositoryType;
use App\Models\Repository;

beforeEach(function () {
    $this->actionSpy = $this->spy(ImportRepositoryReleasesAction::class);
});

it('imports releases for every package repository', function () {
    $package = Repository::factory()->create(['type' => RepositoryType::PACKAGE]);

    $this->artisan(ImportGitHubReleasesCommand::class)->assertSuccessful();

    $this->actionSpy->shouldHaveReceived('execute')
        ->withArgs(fn (Repository $repository) => $repository->is($package))
        ->once();
});

it('does not import releases for project repositories', function () {
    Repository::factory()->create(['type' => RepositoryType::PROJECT]);

    $this->artisan(ImportGitHubReleasesCommand::class)->assertSuccessful();

    $this->actionSpy->shouldNotHaveReceived('execute');
});
