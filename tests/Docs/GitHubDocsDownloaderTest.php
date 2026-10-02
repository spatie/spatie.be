<?php

use App\Docs\GitHubDocsDownloader;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\Docs\Support\FakeGitHubDocs;

beforeEach(function () {
    FakeGitHubDocs::make()->branch('spatie/laravel-backup', 'main', [
        'introduction.md' => 'introduction',
        'images/my screenshot.png' => 'png contents',
    ]);
});

it('yields the files in the docs folder of the latest commit of a branch', function () {
    $downloader = app(GitHubDocsDownloader::class);

    $commit = $downloader->latestCommit('spatie/laravel-backup', 'main');

    expect(iterator_to_array($downloader->docsFiles('spatie/laravel-backup', $commit)))->toBe([
        'introduction.md' => 'introduction',
        'images/my screenshot.png' => 'png contents',
    ]);

    Http::assertSent(fn (Request $request) => $request->url() === "https://raw.githubusercontent.com/spatie/laravel-backup/{$commit}/docs/images/my%20screenshot.png");
});

it('returns no commit for a branch that does not exist', function () {
    expect(app(GitHubDocsDownloader::class)->latestCommit('spatie/laravel-backup', 'v1'))->toBeNull();
});
