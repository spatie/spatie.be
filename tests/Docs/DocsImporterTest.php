<?php

use App\Docs\Docs;
use App\Docs\DocsImporter;
use App\Docs\DocsStorage;
use App\Exceptions\DocsImportException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\Docs\Support\FakeGitHubDocs;

function introductionOf(string $version): string
{
    return app(Docs::class)
        ->getRepository('laravel-backup')
        ->getAlias($version)
        ->pages
        ->firstWhere('slug', 'introduction')
        ->contents;
}

beforeEach(function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');

    config()->set('docs.cache_store', 'array');
    config()->set('services.github.docs_access_token', 'docs-token');

    $this->repository = [
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => [
            'main' => 'v9',
            'v8' => 'v8',
        ],
        'category' => 'Laravel',
    ];

    $this->gitHub = FakeGitHubDocs::make()
        ->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9'))
        ->branch('spatie/laravel-backup', 'v8', FakeGitHubDocs::docsForVersion('v8'));
});

it('downloads the docs of every branch with the docs token', function () {
    app(DocsImporter::class)->import($this->repository);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-backup/branches/main'
        && $request->hasHeader('Authorization', 'Bearer docs-token'));

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.github.com/repos/spatie/laravel-backup/branches/v8');

    Http::assertSent(fn (Request $request) => str_starts_with($request->url(), 'https://raw.githubusercontent.com/spatie/laravel-backup/')
        && str_ends_with($request->url(), '/docs/basic-usage/taking-backups.md')
        && $request->hasHeader('Authorization', 'Bearer docs-token'));

    Http::assertNotSent(fn (Request $request) => str_ends_with($request->url(), 'README.md') || str_ends_with($request->url(), 'symlink.md'));
});

it('writes the markdown of every branch to a new release on the docs disk', function () {
    app(DocsImporter::class)->import($this->repository);

    $releasePath = app(DocsStorage::class)->currentReleasePath('laravel-backup');

    expect($releasePath)->toStartWith('laravel-backup/releases/');

    Storage::disk('docs')->assertExists([
        "{$releasePath}/_index.md",
        "{$releasePath}/v9/_index.md",
        "{$releasePath}/v9/introduction.md",
        "{$releasePath}/v9/basic-usage/taking-backups.md",
        "{$releasePath}/v8/introduction.md",
    ]);

    expect(Storage::disk('docs')->get("{$releasePath}/_index.md"))
        ->toBe("---\ntitle: laravel-backup\ncategory: Laravel\n---\n");

    Storage::disk('docs')->assertMissing("{$releasePath}/v9/images/header.png");
});

it('writes the other files to the assets disk at the path they are served from', function () {
    app(DocsImporter::class)->import($this->repository);

    Storage::disk('docs-assets')->assertExists([
        'laravel-backup/v9/images/header.png',
        'laravel-backup/v8/images/header.png',
    ]);

    Storage::disk('docs-assets')->assertMissing('laravel-backup/v9/introduction.md');

    expect(Storage::disk('docs-assets')->get('laravel-backup/v9/images/header.png'))->toBe('png contents');
});

it('makes the imported docs available', function () {
    app(DocsImporter::class)->import($this->repository);

    $repository = app(Docs::class)->getRepository('laravel-backup');

    expect($repository->category)->toBe('Laravel');
    expect($repository->aliases->pluck('slug')->all())->toBe(['v9', 'v8']);
    expect($repository->getAlias('v9')->pages->pluck('slug')->all())
        ->toEqualCanonicalizing(['introduction', 'basic-usage/_index', 'basic-usage/taking-backups']);
});

it('refreshes the cached docs after an import', function () {
    app(DocsImporter::class)->import($this->repository);

    expect(introductionOf('v9'))->toContain('Introduction text');

    $this->gitHub->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9', 'Updated introduction'));

    app(DocsImporter::class)->import($this->repository);

    expect(introductionOf('v9'))->toContain('Updated introduction');
});

it('keeps serving the current release while a new one is being imported', function () {
    app(DocsImporter::class)->import($this->repository);

    $this->gitHub
        ->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9', 'Updated introduction'))
        ->beforeResponding('spatie/laravel-backup', 'v8', function () {
            Cache::store('array')->flush();

            expect(introductionOf('v9'))->toContain('Introduction text');
        });

    app(DocsImporter::class)->import($this->repository);

    expect(introductionOf('v9'))->toContain('Updated introduction');
});

it('keeps the current docs when a branch fails to download', function () {
    app(DocsImporter::class)->import($this->repository);

    $releasePath = app(DocsStorage::class)->currentReleasePath('laravel-backup');

    $this->gitHub
        ->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9', 'Updated introduction'))
        ->failingBranch('spatie/laravel-backup', 'v8');

    expect(fn () => app(DocsImporter::class)->import($this->repository))->toThrow(RequestException::class);

    expect(app(DocsStorage::class)->currentReleasePath('laravel-backup'))->toBe($releasePath);
    expect(Storage::disk('docs')->directories('laravel-backup/releases'))->toBe([$releasePath]);

    Cache::store('array')->flush();

    expect(introductionOf('v9'))->toContain('Introduction text');
});

it('keeps the current docs when a file fails to download', function () {
    app(DocsImporter::class)->import($this->repository);

    $releasePath = app(DocsStorage::class)->currentReleasePath('laravel-backup');

    $this->gitHub
        ->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9', 'Updated introduction'))
        ->failingFile('basic-usage/taking-backups.md');

    expect(fn () => app(DocsImporter::class)->import($this->repository))->toThrow(DocsImportException::class);

    expect(app(DocsStorage::class)->currentReleasePath('laravel-backup'))->toBe($releasePath);
    expect(Storage::disk('docs')->directories('laravel-backup/releases'))->toBe([$releasePath]);
});

it('skips a branch that does not exist', function () {
    $this->repository['branches']['v7'] = 'v7';

    app(DocsImporter::class)->import($this->repository);

    expect(app(Docs::class)->getRepository('laravel-backup')->aliases->pluck('slug')->all())->toBe(['v9', 'v8']);
});

it('keeps the current docs when no docs were found at all', function () {
    app(DocsImporter::class)->import($this->repository);

    $releasePath = app(DocsStorage::class)->currentReleasePath('laravel-backup');

    $this->repository['branches'] = ['missing' => 'v10'];

    expect(fn () => app(DocsImporter::class)->import($this->repository))->toThrow(DocsImportException::class);

    expect(app(DocsStorage::class)->currentReleasePath('laravel-backup'))->toBe($releasePath);
    expect(Storage::disk('docs')->directories('laravel-backup/releases'))->toBe([$releasePath]);
});

it('only keeps the current and the previous release', function () {
    foreach (range(1, 3) as $importNumber) {
        app(DocsImporter::class)->import($this->repository);

        $releasePaths[] = app(DocsStorage::class)->currentReleasePath('laravel-backup');
    }

    expect(Storage::disk('docs')->directories('laravel-backup/releases'))->toEqualCanonicalizing([$releasePaths[1], $releasePaths[2]]);
});

it('reads docs that were imported before releases existed', function () {
    collect(FakeGitHubDocs::docsForVersion('v8', 'Legacy introduction'))
        ->reject(fn (string $contents, string $path) => str_ends_with($path, '.png'))
        ->each(fn (string $contents, string $path) => Storage::disk('docs')->put("laravel-backup/v8/{$path}", $contents));

    Storage::disk('docs')->put('laravel-backup/_index.md', "---\ntitle: laravel-backup\ncategory: Laravel\n---\n");

    expect(app(DocsStorage::class)->usesLegacyLayout('laravel-backup'))->toBeTrue();
    expect(introductionOf('v8'))->toContain('Legacy introduction');
});

it('removes the docs that were imported before releases existed once they are no longer the previous release', function () {
    Storage::disk('docs')->put('laravel-backup/_index.md', 'legacy');
    Storage::disk('docs')->put('laravel-backup/v8/introduction.md', 'legacy');

    app(DocsImporter::class)->import($this->repository);

    Storage::disk('docs')->assertExists('laravel-backup/v8/introduction.md');

    app(DocsImporter::class)->import($this->repository);

    Storage::disk('docs')->assertMissing(['laravel-backup/_index.md', 'laravel-backup/v8/introduction.md']);
    Storage::disk('docs')->assertExists('laravel-backup/current-release');
    expect(introductionOf('v9'))->toContain('Introduction text');
});
