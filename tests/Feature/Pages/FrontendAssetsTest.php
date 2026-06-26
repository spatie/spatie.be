<?php

use Illuminate\Testing\TestResponse;

function assertLivewireAssetsAreLoaded(TestResponse $response): void
{
    expect($response->getContent())
        ->toContain('Livewire Styles')
        ->toContain('Livewire Scripts')
        ->toContain('data-update-uri');
}

function assertCommentAndSimpleMdeAssetsAreNotLoaded(TestResponse $response): void
{
    expect($response->getContent())
        ->not->toContain('_laravel-comments-livewire')
        ->not->toContain('simplemde')
        ->not->toContain('SimpleMDE');
}

it('loads livewire assets on a static page for alpine and navigation', function () {
    $response = $this->get(route('legal.index'));

    $response->assertOk();

    assertLivewireAssetsAreLoaded($response);
    assertCommentAndSimpleMdeAssetsAreNotLoaded($response);
});

it('loads livewire assets on livewire pages', function () {
    $response = $this->get(route('home'));

    $response->assertOk();

    assertLivewireAssetsAreLoaded($response);
    assertCommentAndSimpleMdeAssetsAreNotLoaded($response);
});

it('loads livewire assets on docs pages', function (string $url) {
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
    'home' => ['/'],
    'docs' => ['/docs'],
    'legal' => ['/legal'],
    'guidelines' => ['/guidelines'],
]);
