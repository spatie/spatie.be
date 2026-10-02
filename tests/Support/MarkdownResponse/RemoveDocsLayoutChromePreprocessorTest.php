<?php

use App\Support\MarkdownResponse\RemoveDocsLayoutChromePreprocessor;

it('removes the layout chrome from docs html', function () {
    $html = '<div><header>Header</header><main>Docs content</main><footer>Footer</footer></div>';

    $processedHtml = (new RemoveDocsLayoutChromePreprocessor())($html);

    expect($processedHtml)
        ->toContain('Docs content')
        ->not->toContain('Header')
        ->not->toContain('Footer');
});

it('returns empty html untouched', function (string $html) {
    expect((new RemoveDocsLayoutChromePreprocessor())($html))->toBe($html);
})->with([
    'empty' => '',
    'whitespace' => "  \n ",
]);
