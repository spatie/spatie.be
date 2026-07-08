<?php

use Database\Seeders\DocsSeeder;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\TestResponse;
use Illuminate\View\Middleware\ShareErrorsFromSession;

function assertLivewireAssetsAreLoaded(TestResponse $response): void
{
    expect($response->getContent())
        ->toContain('Livewire Styles')
        ->toContain('Livewire Scripts')
        ->toContain('data-update-uri');
}

function assertLivewireAssetsAreNotLoaded(TestResponse $response): void
{
    expect($response->getContent())
        ->not->toContain('Livewire Styles')
        ->not->toContain('Livewire Scripts')
        ->not->toContain('data-update-uri');
}

function assertCommentAndSimpleMdeAssetsAreNotLoaded(TestResponse $response): void
{
    expect($response->getContent())
        ->not->toContain('_laravel-comments-livewire')
        ->not->toContain('simplemde')
        ->not->toContain('SimpleMDE');
}

it('does not load livewire assets on a static page', function () {
    $response = $this->get(route('legal.index'));

    $response->assertOk();

    assertLivewireAssetsAreNotLoaded($response);
    assertCommentAndSimpleMdeAssetsAreNotLoaded($response);
});

it('does not load livewire assets on the homepage', function () {
    $response = $this->get(route('home'));

    $response->assertOk();

    $content = $response->getContent();

    assertLivewireAssetsAreNotLoaded($response);
    assertCommentAndSimpleMdeAssetsAreNotLoaded($response);
    expect($content)
        ->toContain('newsletter-subscriptions')
        ->toContain('fonts/Druk-Bold-Web.woff2')
        ->toContain('requestIdleCallback')
        ->not->toContain('newsletter-inline')
        ->not->toContain('resources/css/front/front.css')
        ->not->toContain('unpkg.com/@alpinejs/focus')
        ->not->toContain('serviceWorker.getRegistrations');

    expect(file_get_contents(resource_path('views/front/pages/home/index.blade.php')))
        ->toContain('css-entry="resources/css/front/home.css"');
});

it('does not start a session on the homepage', function () {
    expect(Route::getRoutes()->getByName('home')->excludedMiddleware())
        ->toContain(StartSession::class)
        ->toContain(ShareErrorsFromSession::class);
});

it('loads livewire assets on livewire pages', function () {
    $response = $this->get(route('newsletter'));

    $response->assertOk();

    assertLivewireAssetsAreLoaded($response);
    assertCommentAndSimpleMdeAssetsAreNotLoaded($response);
});

it('loads livewire assets on docs pages', function (string $url) {
    $this->seed(DocsSeeder::class);

    $response = $this->get($url);

    $response->assertOk();

    assertLivewireAssetsAreLoaded($response);
    assertCommentAndSimpleMdeAssetsAreNotLoaded($response);
})->with([
    'docs index' => ['/docs'],
    'docs show' => ['/docs/laravel-data/v4/introduction'],
]);

it('does not load comment or simplemde assets on normal pages', function (string $url) {
    $response = $this->get($url);

    $response->assertOk();

    assertCommentAndSimpleMdeAssetsAreNotLoaded($response);
})->with([
    'docs' => ['/docs'],
    'legal' => ['/legal'],
    'guidelines' => ['/guidelines'],
]);
