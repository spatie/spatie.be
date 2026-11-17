<?php

use App\Docs\DocsImporter;
use App\Domain\Blog\Models\BlogPost;
use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Product;
use App\Models\Series;
use Illuminate\Support\Facades\Storage;
use Tests\Docs\Support\FakeGitHubDocs;

it('lists public canonical pages without exposing unpublished content or private routes', function () {
    $this->travelTo(now()->startOfSecond());
    Storage::fake('docs');
    Storage::fake('docs-assets');
    config()->set('docs.cache_store', 'array');

    $repository = [
        'name' => 'laravel-backup',
        'repository' => 'spatie/laravel-backup',
        'branches' => ['main' => 'v9'],
        'category' => 'Laravel',
    ];
    config()->set('docs.repositories', [$repository]);
    FakeGitHubDocs::make()->branch('spatie/laravel-backup', 'main', FakeGitHubDocs::docsForVersion('v9'));
    app(DocsImporter::class)->import($repository);

    $post = BlogPost::factory()->create(['published_at' => now()]);
    $draft = BlogPost::factory()->create(['published' => false]);
    $future = BlogPost::factory()->create(['published_at' => now()->addSecond()]);
    $deleted = BlogPost::factory()->create();
    $deleted->delete();
    $product = Product::factory()->create(['visible' => true]);
    $hiddenProduct = Product::factory()->create(['visible' => false]);
    $bundle = Bundle::factory()->create(['visible' => true]);
    $hiddenBundle = Bundle::factory()->create(['visible' => false]);
    $series = Series::factory()->create(['visible' => true, 'slug' => 'public-course']);
    $hiddenSeries = Series::factory()->create(['visible' => false, 'slug' => 'hidden-course']);

    $response = $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
    $xml = simplexml_load_string($response->getContent());
    expect($xml->getName())->toBe('urlset');
    expect($xml->getDocNamespaces())->toBe(['' => 'http://www.sitemaps.org/schemas/sitemap/0.9']);
    $urls = array_map('strval', iterator_to_array($xml->xpath('//*[local-name()="loc"]')));

    expect($urls)->toContain(
        url('/'),
        route('docs'),
        route('products.index'),
        route('legal.privacy'),
        route('blog.show', $post->slug),
        route('products.show', $product),
        route('bundles.show', $bundle->slug),
        route('series.show', $series),
        url('/docs/laravel-backup/v9/introduction'),
        url('/docs/laravel-backup/v9/basic-usage/taking-backups'),
    )->not->toContain(
        route('blog.show', $draft->slug),
        route('blog.show', $future->slug),
        route('blog.show', $deleted->slug),
        route('products.show', $hiddenProduct),
        route('bundles.show', $hiddenBundle->slug),
        route('series.show', $hiddenSeries),
        url('/docs/laravel-backup'),
        url('/docs/laravel-backup/v9/basic-usage/_index'),
        url('/login'),
        url('/profile'),
        url('/admin'),
        url('/top-secret'),
    );
    expect($urls)->toHaveCount(count(array_unique($urls)));
    expect(file_get_contents(public_path('robots.txt')))->toContain('Sitemap: https://spatie.be/sitemap.xml');

    $post->update(['published' => false]);
    $this->travel(1)->seconds();
    $this->get('/sitemap.xml')->assertOk()
        ->assertDontSee(route('blog.show', $post->slug))
        ->assertSee(route('blog.show', $future->slug));
});
