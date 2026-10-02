<?php

use App\Docs\DocsArchive;
use App\Exceptions\DocsImportException;
use Tests\Docs\Support\Zipball;

function docsArchiveFor(string $zipContents): DocsArchive
{
    $path = tempnam(sys_get_temp_dir(), 'docs-archive-test-');

    file_put_contents($path, $zipContents);

    return new DocsArchive($path);
}

it('only extracts the files in the docs folder', function () {
    $archive = docsArchiveFor(Zipball::make([
        'README.md' => '# Readme',
        'src/Package.php' => '<?php',
        'tests/docs/fixture.md' => 'not the docs folder',
        'docs/_index.md' => 'index',
        'docs/introduction.md' => 'introduction',
        'docs/basic-usage/getting-started.md' => 'getting started',
        'docs/images/header.png' => 'png contents',
    ]));

    expect(iterator_to_array($archive->docsFiles()))->toEqual([
        '_index.md' => 'index',
        'introduction.md' => 'introduction',
        'basic-usage/getting-started.md' => 'getting started',
        'images/header.png' => 'png contents',
    ]);
});

it('skips paths that would escape the docs folder', function () {
    $archive = docsArchiveFor(Zipball::make([
        'docs/introduction.md' => 'introduction',
        'docs/../../evil.md' => 'evil',
    ]));

    expect(iterator_to_array($archive->docsFiles()))->toEqual([
        'introduction.md' => 'introduction',
    ]);
});

it('yields nothing when there is no docs folder', function () {
    $archive = docsArchiveFor(Zipball::make([
        'README.md' => '# Readme',
    ]));

    expect(iterator_to_array($archive->docsFiles()))->toBeEmpty();
});

it('throws when the archive is not a zip', function () {
    iterator_to_array(docsArchiveFor('not a zip')->docsFiles());
})->throws(DocsImportException::class);
