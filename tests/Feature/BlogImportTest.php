<?php

use App\Domain\Blog\Models\BlogPost;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

beforeEach(function () {
    Storage::fake('local');
    Storage::fake('medialibrary');
    $this->snapshot = Storage::disk('local')->path('snapshot');
    mkdir($this->snapshot);
    $image = UploadedFile::fake()->image('cover.png', 800, 600);
    copy($image->getPathname(), $this->snapshot.'/cover.png');

    $entries = collect([true, false])->map(function (bool $published) {
        $id = (string) Str::uuid();
        $markdown = "![A cover](/assets/cover.png)\n\n[Read more][asset]\n\n[asset]: https://content.spatie.be/assets/cover.png";
        file_put_contents($this->snapshot.'/'.$id.'.md', $markdown);

        return [
            'record' => [
                'id' => $id, 'collection' => 'posts', 'slug' => $published ? 'published-post' : 'draft-post', 'published' => (int) $published,
                'created_at' => '2025-01-02 03:04:05', 'updated_at' => '2026-02-03 04:05:06',
                'data' => [
                    'product' => 'spatie', 'title' => $published ? 'Published post' : 'Draft post',
                    'content' => $markdown, 'summary' => '**Summary**', 'authors' => ['author-b', 'author-a'],
                    'tags' => ['laravel'], 'header_image' => 'cover.png', 'og_image' => null,
                ],
            ],
            'date_utc' => '2025-07-03T23:34:56+00:00', 'has_working_copy' => false,
            'markdown_file' => $id.'.md', 'markdown_sha256' => hash('sha256', $markdown),
        ];
    })->all();

    $this->manifest = [
        'schema_version' => 1,
        'source' => ['timezone' => 'UTC'],
        'entries' => $entries,
        'authors' => [['id' => 'author-a', 'name' => 'Alex'], ['id' => 'author-b', 'name' => 'Freek']],
        'tags' => [['slug' => 'laravel', 'title' => 'Laravel']],
        'assets' => [[
            'path' => 'cover.png', 'file' => 'cover.png', 'sha256' => hash_file('sha256', $image->getPathname()), 'bytes' => filesize($image->getPathname()),
            'references' => collect($entries)->map(fn ($entry) => ['entry_id' => $entry['record']['id'], 'field' => 'content'])->all(),
        ]],
    ];
    file_put_contents($this->snapshot.'/manifest.json', json_encode($this->manifest));
});

it('imports editable source and media without exposing drafts or overwriting later edits', function () {
    $this->artisan('blog:import', ['snapshot' => $this->snapshot, '--dry-run' => true])->assertSuccessful();
    expect(BlogPost::count())->toBe(0);
    expect(Storage::disk('medialibrary')->allFiles())->toBeEmpty();

    $this->artisan('blog:import', ['snapshot' => $this->snapshot])->assertSuccessful();
    $post = BlogPost::where('slug', 'published-post')->sole();
    expect($post->authors->pluck('name')->all())->toBe(['Freek', 'Alex']);
    expect($post->tags)->toBe(['Laravel']);
    expect($post->published_at->utc()->format('Y-m-d H:i:s'))->toBe('2025-07-03 23:34:56');
    expect($post->updated_at->utc()->format('Y-m-d H:i:s'))->toBe('2026-02-03 04:05:06');
    expect($post->markdown)->not->toContain('/assets/', 'content.spatie.be');
    $this->get('/blog/published-post')->assertSuccessful()->assertSee($post->header_image)->assertSee('July 03, 2025');
    $this->get('/blog/draft-post')->assertNotFound();
    $files = Storage::disk('medialibrary')->allFiles();
    $post->update(['title' => 'Edited locally']);
    $draft = BlogPost::where('slug', 'draft-post')->sole();
    $draft->delete();

    $this->artisan('blog:import', ['snapshot' => $this->snapshot])->assertSuccessful();
    expect($post->refresh()->title)->toBe('Edited locally');
    expect(BlogPost::withTrashed()->count())->toBe(2);
    expect($draft->refresh()->trashed())->toBeTrue();
    expect(Storage::disk('medialibrary')->allFiles())->toBe($files);
});

it('rejects broken source references before writing any posts or media', function () {
    $entry = &$this->manifest['entries'][1];
    $entry['record']['data']['content'] .= '\n<img src="/assets/missing.png">';
    $entry['markdown_sha256'] = hash('sha256', $entry['record']['data']['content']);
    file_put_contents($this->snapshot.'/'.$entry['markdown_file'], $entry['record']['data']['content']);
    file_put_contents($this->snapshot.'/manifest.json', json_encode($this->manifest));

    expect(fn () => $this->artisan('blog:import', ['snapshot' => $this->snapshot])->run())
        ->toThrow(RuntimeException::class, 'Unresolved source media');
    expect(BlogPost::count())->toBe(0);
    expect(Storage::disk('medialibrary')->allFiles())->toBeEmpty();
});
