<?php

namespace Tests\Docs\Highlighting;

use App\Docs\Highlighting\DiffLanguage;
use Tempest\Highlight\Highlighter;

it('highlights diff code blocks without throwing', function () {
    $highlighter = new Highlighter();
    $highlighter->addLanguage(new DiffLanguage());

    $html = $highlighter->parse("+ added line\n- removed line", 'diff');

    expect($html)
        ->toContain('hl-addition')
        ->toContain('hl-deletion');
});
