<?php

use App\Docs\Docs;
use App\Docs\DocsImporter;
use App\Docs\DocsStorage;
use App\Livewire\SearchDocsComponent;
use App\Models\Member;
use App\Models\Repository;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use App\Spotlight\Spotlight;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\Docs\Support\FakeGitHubDocs;

beforeEach(function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');
    Storage::fake('public');
    Storage::fake('github_ads');
    config(['docs.cache_store' => 'array', 'markdown.cache_store' => 'array']);

    $this->app->make(\Illuminate\Contracts\Http\Kernel::class)
        ->prependMiddleware(\Spatie\MarkdownResponse\Middleware\RewriteMarkdownUrls::class);

    $this->privateRepositories = collect(['internal-example', 'internal-guide'])->map(fn (string $name) => [
        'name' => $name,
        'repository' => "spatie/{$name}",
        'branches' => ['main' => 'v1'],
        'category' => 'Other',
    ]);
    $this->gitHub = FakeGitHubDocs::make();
    foreach ($this->privateRepositories as $repository) {
        $this->artisan('docs:register-staff', ['name' => $repository['name'], '--category' => $repository['category']])->assertSuccessful();
        $this->gitHub->branch($repository['repository'], 'main', FakeGitHubDocs::docsForVersion('v1', 'Confidential guide. ' . str_repeat('Details. ', 50) . 'Needleafterlongprefix'));
        app(DocsImporter::class)->import($repository);
    }

    $this->staff = User::factory()->create(['email' => 'staff@spatie.be', 'is_admin' => true]);
    Member::factory()->create(['email' => $this->staff->email]);
});

it('conceals staff repositories from guests and untrusted accounts on every public surface', function (?string $email, bool $admin) {
    if ($email) {
        $this->actingAs(User::factory()->create(['email' => $email, 'is_admin' => $admin]));
        Member::factory()->create(['email' => $email]);
    }

    foreach (['/docs', '/open-source/packages', '/llms.txt', '/sitemap.xml'] as $url) {
        $response = $this->get($url)->assertOk();
        foreach ($this->privateRepositories as $repository) {
            $response->assertDontSee($repository['name']);
        }
    }

    foreach ($this->privateRepositories as $repository) {
        $name = $repository['name'];
        foreach ([
            "/docs/{$name}",
            "/docs/{$name}/v1/introduction",
            "/docs/{$name}/v1/introduction.md",
            "/docs/{$name}/v1/llms.txt",
            "/docs/{$name}/v1/images/header.png",
            "/docs/{$name}/v1/introduction?ogimage",
            "/packages/header/{$name}/html/dark",
            "/packages/header/{$name}/html/dark.webp",
            "/github-ad-image/{$name}.jpg",
            "/github-ad-click/{$name}",
        ] as $url) {
            $response = $this->get($url)->assertNotFound()->assertDontSee('Confidential guide.');
            expect($response->headers->has('Location'))->toBeFalse();
            expect($response->headers->get('Cache-Control'))->toContain('no-store');
        }
        $this->get("/docs/{$name}/v1/introduction", ['Accept' => 'text/markdown'])->assertNotFound();
    }

    Livewire::test(Spotlight::class)->assertDontSee('internal-example')
        ->call('execute', 'internal-example')->assertNotFound();

    Livewire::test(SearchDocsComponent::class)
        ->set('currentUrl', 'https://spatie.be/docs/internal-example/v1/introduction')
        ->set('query', 'Confidential')
        ->assertNotFound();
})->with([
    'guest' => [null, false],
    'external customer' => ['customer@example.com', false],
    'self-registered staff email' => ['untrusted@spatie.be', false],
    'lookalike domain admin' => ['admin@spatie.be.example.com', true],
]);

it('shows staff the docs and list without placing confidential assets in public storage or discovery feeds', function () {
    $this->actingAs($this->staff);

    Livewire::test(Spotlight::class)->assertSee('internal-example');

    $index = $this->get('/docs')->assertOk();
    $list = $this->get('/open-source/packages')->assertOk();
    expect($index->headers->get('Cache-Control'))->toContain('no-store', 'private');
    expect($list->headers->get('Cache-Control'))->toContain('no-store', 'private');

    foreach ($this->privateRepositories as $repository) {
        $name = $repository['name'];
        $index->assertSee($name);
        $list->assertSee($name);
        $this->get("/docs/{$name}/v1/introduction")
            ->assertOk()->assertSee('Confidential guide.')
            ->assertSee('data-og-url=', escape: false)
            ->assertDontSee('data-og-hash=', escape: false);
        $this->get("/docs/{$name}/v1/introduction.md")->assertOk()->assertSee('Confidential guide.');
        $this->get("/docs/{$name}/v1/llms.txt")->assertOk()->assertSee($name);
        $image = $this->get("/docs/{$name}/v1/images/header.png")->assertOk();
        expect($image->headers->get('Cache-Control'))->toContain('no-store', 'private');
        expect($image->streamedContent())->toBe('png contents');
        Storage::disk('docs-assets')->assertMissing("{$name}/v1/images/header.png");
        Storage::disk('docs')->assertExists(app(DocsStorage::class)->currentReleasePath($name).'/v1/images/header.png');
        $this->get('/llms.txt')->assertDontSee($name);
        $this->get('/sitemap.xml')->assertDontSee($name);
    }

    Livewire::test(SearchDocsComponent::class)
        ->set('currentUrl', 'https://spatie.be/docs/internal-example/v1/introduction')
        ->set('query', 'Needleafterlongprefix')
        ->assertSee('Confidential guide.')
        ->set('query', 'absentword')->assertDontSee('Confidential guide.');

    $this->app['auth']->forgetGuards();
    $this->get('/docs/internal-example/v1/introduction')->assertNotFound();
    $this->get('/docs')->assertDontSee('internal-example');
});

it('never serves or generates cached og images for staff-only pages', function () {
    Cache::forever('og-image:abc123', ['url' => 'https://spatie.be/docs/internal-example/v1/introduction']);
    Storage::disk('public')->put('og-images/abc123.jpeg', 'confidential image');

    $this->get('/og-image/abc123.jpeg')->assertNotFound();
    $this->actingAs($this->staff)->get('/og-image/abc123.jpeg')->assertNotFound();
    $this->get('/docs/internal-example/v1/introduction?ogimage')->assertNotFound();
});

it('imports database-configured docs through the normal command without publishing their configuration', function () {
    expect(collect(config('docs.repositories'))->contains('name', 'internal-example'))->toBeFalse();
    expect(Docs::configurations()->firstWhere('name', 'internal-example')['branches'])->toBe(['main' => 'v1']);

    $this->gitHub->branch('spatie/internal-example', 'main', FakeGitHubDocs::docsForVersion('v1', 'Updated private guide'));
    $this->artisan('docs:import', ['--repo' => 'spatie/internal-example'])->assertSuccessful();

    $this->actingAs($this->staff)->get('/docs/internal-example/v1/introduction')->assertOk()->assertSee('Updated private guide');
    $this->app['auth']->forgetGuards();
    $this->get('/docs/internal-example/v1/introduction')->assertNotFound();
});

it('defaults new repositories to staff access and preserves it during public repository synchronization', function () {
    $repository = Repository::create(['name' => 'internal-draft']);
    expect($repository->visibility)->toBe('staff');

    $attributes = fn (string $name) => [
        'name' => $name,
        'description' => 'Example package',
        'stargazers_count' => 12,
        'language' => 'PHP',
        'created_at' => '2026-01-01T00:00:00+00:00',
    ];

    $this->mock(GitHubApi::class, function ($mock) use ($attributes) {
        $mock->shouldReceive('fetchPublicRepositories')->with('spatie')->andReturn(collect([
            $attributes('internal-example'), $attributes('public-example'),
        ]));
        $mock->shouldReceive('fetchRepositoryTopics')->andReturn(collect());
    });

    $this->artisan('import:github-repositories')->assertSuccessful();

    expect(Repository::whereName('internal-example')->first()->visibility)->toBe('staff');
    expect(Repository::whereName('public-example')->first()->visibility)->toBe('public');
    $this->get('/open-source/packages')->assertSee('public-example')->assertDontSee('internal-example');
});
