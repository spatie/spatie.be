<?php

use App\Docs\DocsImporter;
use Illuminate\Support\Facades\Storage;
use Tests\Docs\Support\FakeGitHubDocs;

it('links a concise entry point to complete versioned package indexes', function () {
    Storage::fake('docs');
    Storage::fake('docs-assets');

    $repository = [
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => ['main' => 'v9', 'v8' => 'v8'],
        'category' => 'Laravel',
    ];

    config()->set('docs.cache_store', 'array');
    config()->set('docs.repositories', [$repository]);

    $olderDocs = FakeGitHubDocs::docsForVersion('v8');
    $olderDocs['old-options.md'] = "---\ntitle: Old options\nweight: 3\n---\n\nOld options text.\n";

    FakeGitHubDocs::make()
        ->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9'))
        ->branch('spatie/laravel-backup', 'v8', $olderDocs);

    app(DocsImporter::class)->import($repository);

    $indexUrl = url('/docs/laravel-backup/v9/llms.txt');
    $olderIndexUrl = url('/docs/laravel-backup/v8/llms.txt');

    $this->get('/llms.txt')->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee("[laravel-backup (v9)]({$indexUrl}): Backups made easy", false)
        ->assertDontSee('taking-backups.md')
        ->assertDontSee($olderIndexUrl, false);

    $this->get($indexUrl)->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee('# laravel-backup v9')
        ->assertSee('[Introduction]('.url('/docs/laravel-backup/v9/introduction.md').')', false)
        ->assertSee('[Taking backups]('.url('/docs/laravel-backup/v9/basic-usage/taking-backups.md').')', false)
        ->assertSee("[v8]({$olderIndexUrl})", false)
        ->assertDontSee('_index.md')
        ->assertDontSee('header.png')
        ->assertDontSee('old-options.md');

    $this->get($olderIndexUrl)->assertOk()
        ->assertSee('# laravel-backup v8')
        ->assertSee('[Old options]('.url('/docs/laravel-backup/v8/old-options.md').')', false)
        ->assertSee("[v9]({$indexUrl})", false)
        ->assertDontSee('/v9/introduction.md');

    $this->head($indexUrl)->assertOk()->assertContent('');
    $this->get('/docs/laravel-backup/v999/llms.txt')->assertNotFound();
    $this->get('/docs/unknown/v9/llms.txt')->assertNotFound();
});
