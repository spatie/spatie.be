<?php

namespace Tests\Docs;

use App\Docs\Alias;
use App\Docs\DocumentationPage;

test('it can calculate the version number', function (string $title, int $version) {
    $documentationPage = new DocumentationPage();

    $documentationPage->slug = '_index';
    $documentationPage->alias = $title;
    $documentationPage->title = $title;
    $documentationPage->slogan = 'Associate files with Eloquent models.';
    $documentationPage->githubUrl = 'https://github.com/spatie/laravel-medialibrary';
    $documentationPage->branch = 'main';

    $alias = Alias::fromDocumentationPage($documentationPage, collect());

    expect($alias)->versionNumber
        ->toBeInt()
        ->toEqual($version);
})->with([
    ['v10', 10],
    ['v9', 9],
    ['8', 8],
    ['prefix5suffix', 5]
]);
