<?php

use App\Domain\Blog\Models\BlogPost;
use App\Filament\Resources\Content\BlogPostResource\Pages\CreateBlogPost;
use App\Filament\Resources\Content\BlogPostResource\Pages\EditBlogPost;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('serves only published posts whose publication date has arrived across blog and feed', function () {
    $this->travelTo(now()->startOfSecond());
    $visible = BlogPost::factory()->create(['title' => 'Visible at the boundary', 'published_at' => now()]);
    $draft = BlogPost::factory()->create(['title' => 'Private draft title', 'published' => false]);
    $future = BlogPost::factory()->create(['title' => 'Future title', 'published_at' => now()->addSecond()]);

    foreach (['/blog', '/blog/all', '/feeds/blog', '/'] as $url) {
        $this->get($url)->assertSuccessful()->assertSee($visible->title)->assertDontSee($draft->title)->assertDontSee($future->title);
    }

    $this->get('/blog/'.$draft->slug)->assertNotFound();
    $this->get('/blog/'.$future->slug)->assertNotFound();
    $this->get('/blog/123-'.$visible->slug)->assertRedirect('/blog/'.$visible->slug)->assertStatus(301);
    $this->get('/feeds/blog')->assertSee('<id>'.url($visible->slug).'</id>', false);

    $this->travel(1)->seconds();
    $this->get('/blog/'.$future->slug)->assertSuccessful();
});

it('edits Markdown in Filament and publishes, previews and unpublishes without stale pages', function () {
    $this->actingAsSpatie();
    Livewire::test(CreateBlogPost::class)->fillForm([
        'title' => 'A local draft', 'slug' => 'a-local-draft',
        'markdown' => "## Hello\n\n```blade\n{{-- inside a view --}}\n```",
        'summary_markdown' => '**Summary**', 'published' => false,
    ])->call('create')->assertHasNoFormErrors();

    $post = BlogPost::query()->sole();
    $document = Dom\HTMLDocument::createFromString($post->html, LIBXML_NOERROR);
    expect(trim($document->querySelector('pre')->textContent))->toBe('{{-- inside a view --}}');
    $this->get('/blog/'.$post->slug)->assertNotFound();
    $this->get(route('blog.preview', $post))->assertSuccessful()->assertHeader('X-Robots-Tag', 'noindex, nofollow')->assertSee('Hello');

    Livewire::test(EditBlogPost::class, ['record' => $post->id])->fillForm([
        'published' => true, 'published_at' => now()->utc()->subMinute()->toDateTimeString(),
    ])->call('save')->assertHasNoFormErrors();
    $this->get('/blog/'.$post->slug)->assertSuccessful()->assertSee('Hello');
    $this->get('/blog')->assertSee('<strong>Summary</strong>', false);
    $this->get('/feeds/blog')->assertSee('A local draft');

    Livewire::test(EditBlogPost::class, ['record' => $post->id])->fillForm(['published' => false])->call('save')->assertHasNoFormErrors();
    $this->get('/blog/'.$post->slug)->assertNotFound();
    $this->get('/feeds/blog')->assertDontSee('A local draft');
    $this->app['auth']->forgetGuards();
    $this->get(route('blog.preview', $post))->assertRedirect();
});

it('stores a header on the media disk and serves it with responsive sources', function () {
    Storage::fake('medialibrary');
    $this->actingAsSpatie();
    $post = BlogPost::factory()->create();

    Livewire::test(EditBlogPost::class, ['record' => $post->id])
        ->fillForm(['header' => [UploadedFile::fake()->image('cover.png', 1200, 800)]])
        ->call('save')->assertHasNoFormErrors();

    $post->refresh();
    $media = $post->headerMedia();
    expect($media)->not->toBeNull();
    expect($media->disk)->toBe('medialibrary');
    Storage::disk('medialibrary')->assertExists($media->getPathRelativeToRoot());
    $this->get('/blog/'.$post->slug)->assertSuccessful()->assertSee($media->getUrl());

    Livewire::test(EditBlogPost::class, ['record' => $post->id])
        ->fillForm(['header' => [UploadedFile::fake()->image('replacement.png', 800, 600)]])
        ->call('save')->assertHasNoFormErrors();

    expect($post->refresh()->headerMedia()->id)->not->toBe($media->id);
    Storage::disk('medialibrary')->assertExists($media->getPathRelativeToRoot());
    expect($media->refresh()->collection_name)->toBe('attachments');

    Livewire::test(EditBlogPost::class, ['record' => $post->id])
        ->fillForm(['header' => []])->call('save')->assertHasNoFormErrors();

    expect($post->refresh()->header_image)->toBeNull();
    expect($post->media()->count())->toBe(2);
});

it('rejects reserved blog routes in the editor', function (string $slug) {
    $this->actingAsSpatie();
    Livewire::test(CreateBlogPost::class)->fillForm([
        'title' => 'Reserved', 'slug' => $slug, 'markdown' => 'Body',
    ])->call('create')->assertHasFormErrors(['slug']);
    expect(BlogPost::count())->toBe(0);
})->with(['all', 'authors']);
