<?php

use App\Domain\Blog\Models\BlogPost;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('negotiates public articles without changing HTML defaults or ignoring quality values', function (string $accept, bool $markdown) {
    $post = BlogPost::factory()->create();

    foreach (['/guidelines/php', '/blog/'.$post->slug] as $url) {
        $response = $this->get($url, ['Accept' => $accept])->assertOk();
        expect($response->getVary())->toContain('Accept');
        $response->assertHeader('Content-Type', $markdown ? 'text/markdown; charset=UTF-8' : 'text/html; charset=utf-8');
    }
})->with([
    'ordinary browser' => ['text/html', false],
    'no preference' => ['', false],
    'wildcard' => ['*/*', false],
    'Markdown' => ['text/markdown', true],
    'prefer Markdown' => ['text/html;q=0.2, text/markdown;q=0.9', true],
    'prefer HTML' => ['text/markdown;q=0.3, text/html;q=0.8', false],
    'tie keeps HTML' => ['text/markdown, text/html', false],
    'reject Markdown' => ['text/markdown;q=0', false],
    'specific rejection overrides wildcard' => ['text/markdown;q=0, text/*;q=0.8', false],
    'reject HTML but permit other text' => ['text/html;q=0, text/*;q=0.8', true],
]);

it('serves fresh public article content without session chrome, private previews or unpublished posts', function () {
    $this->travelTo(now()->startOfSecond());
    $post = BlogPost::factory()->create([
        'title' => 'A public example',
        'html' => '<h2>Typed collections</h2><p><a href="https://spatie.be/docs">Read the docs</a></p><pre><code class="language-php">$total = 2 &lt; 5; Collection&lt;User&gt;</code></pre><table><tr><th>Package</th><th>Version</th></tr><tr><td>Backup</td><td>9</td></tr></table><script>alert("Not article text")</script>',
        'published_at' => now(),
    ]);

    foreach (['/blog/'.$post->slug.'.md', '/guidelines/php.md'] as $url) {
        $this->withSession(['laravel_flash_message' => [
            'message' => 'Private session marker', 'class' => 'success', 'level' => 'success',
        ]])->get(substr($url, 0, -3), ['Accept' => 'text/html'])->assertSee('Private session marker');

        $response = $this
            ->get($url)->assertOk()
            ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8')
            ->assertHeader('X-Robots-Tag', 'noindex')
            ->assertHeaderMissing('Content-Signal')
            ->assertDontSee('Private session marker')
            ->assertDontSee('<script', false)
            ->assertDontSee('Continue reading')
            ->assertDontSee('Newsletter');

        expect($response->headers->get('Cache-Control'))->toContain('private', 'no-store');
    }

    $this->get('/blog/'.$post->slug, ['Accept' => 'text/markdown'])
        ->assertSee('# A public example', false)
        ->assertSee('## Typed collections', false)
        ->assertSee('[Read the docs](https://spatie.be/docs)', false)
        ->assertSee('$total = 2 < 5; Collection<User>', false)
        ->assertSee('| Backup | 9 |', false)
        ->assertDontSee('Not article text');
    $this->get('/guidelines/php.md')->assertSee('General PHP Rules')
        ->assertSee('public ?string $variable;', false)
        ->assertDontSee('<span', false)->assertDontSee('Permalink');

    $post->update(['html' => '<p>Changed immediately</p>']);
    $this->get('/blog/'.$post->slug.'.md')->assertSee('Changed immediately')->assertDontSee('Typed collections');

    foreach ([['published' => false], ['published' => true, 'published_at' => now()->addSecond()]] as $attributes) {
        $post->update($attributes);
        $this->get('/blog/'.$post->slug.'.md')->assertNotFound();
        $this->get('/blog/'.$post->slug, ['Accept' => 'text/markdown'])->assertNotFound();
    }

    $this->get(route('blog.preview', $post), ['Accept' => 'text/markdown'])->assertRedirect();
    $post->delete();
    $this->get('/blog/'.$post->slug.'.md')->assertNotFound();
    $this->get('/guidelines/unknown.md')->assertNotFound();
    $this->get('/login', ['Accept' => 'text/markdown'])->assertHeader('Content-Type', 'text/html; charset=utf-8');
});

it('respects disabling Markdown responses', function () {
    config()->set('markdown-response.enabled', false);

    $this->get('/guidelines/php', ['Accept' => 'text/markdown'])->assertOk()
        ->assertHeader('Content-Type', 'text/html; charset=utf-8')
        ->assertHeaderMissing('Link');
});

it('advertises working Markdown alternatives only on supported public HTML pages', function () {
    $post = BlogPost::factory()->create();

    foreach (['/guidelines/php', '/blog/'.$post->slug] as $path) {
        $markdownUrl = url($path.'.md');

        $this->get($path.'?utm_source=test')->assertOk()
            ->assertHeader('Link', '<'.$markdownUrl.'>; rel="alternate"; type="text/markdown"');
        $this->head($path)->assertOk()
            ->assertHeader('Link', '<'.$markdownUrl.'>; rel="alternate"; type="text/markdown"');
        $this->get($markdownUrl)->assertOk()
            ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
    }

    config()->set('markdown-response.detection.detect_via_md_suffix', false);
    $this->get('/guidelines/php')->assertOk()
        ->assertHeader('Link', '<'.url('/guidelines/php').'>; rel="alternate"; type="text/markdown"');
    $this->get('/guidelines/php', ['Accept' => 'text/markdown'])->assertOk()
        ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');

    $this->get('/login')->assertHeaderMissing('Link');
    $this->get('/admin')->assertRedirect()->assertHeaderMissing('Link');
    $post->update(['published' => false]);
    $this->get('/blog/'.$post->slug)->assertNotFound()->assertHeaderMissing('Link');
});

it('includes canonical sources and stored blog metadata without inventing guideline dates', function () {
    $this->travelTo('2026-11-17 12:00:00');
    $post = BlogPost::factory()->create([
        'slug' => 'source-context',
        'published_at' => '2026-10-02 09:30:00',
        'updated_at' => '2026-11-16 14:45:00',
        'author_data' => [['name' => 'Zoe'], ['name' => 'Alex']],
    ]);

    foreach (['/blog/source-context', '/blog/source-context.md?utm_source=test'] as $path) {
        $this->get($path, ['Accept' => 'text/markdown'])->assertOk()
            ->assertSee('Source: '.url('/blog/source-context'), false)
            ->assertSee('Authors: Zoe, Alex', false)
            ->assertSee('Published: 2026-10-02T07:30:00+00:00', false)
            ->assertSee('Updated: 2026-11-16T14:45:00+01:00', false)
            ->assertDontSee('utm_source')
            ->assertDontSee('source-context.md');
    }

    $this->get('/guidelines/php.md?utm_source=test')->assertOk()
        ->assertSee('Source: '.url('/guidelines/php'), false)
        ->assertDontSee('Authors:')->assertDontSee('Published:')->assertDontSee('Updated:')
        ->assertDontSee('utm_source')->assertDontSee('/guidelines/php.md');

    $post->update(['author_data' => []]);
    $this->get('/blog/source-context.md')->assertOk()->assertDontSee('Authors:');
});
