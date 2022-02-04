<?php

namespace Tests\Domain\Shop\Models;

use App\Domain\Shop\Models\Release;

it('can convert release notes to html when saving', function () {
    $release = Release::factory()->create();

    $release->notes = "- Add `label` log type
- Disable SQL highlighting (->showQueries() crashed the app because of an issue with the code highlighting)
- Fix placeholder blocks in dark mode
- Fix window bounds resetting on app boot when it was stickied to a side of the screen";

    $release->save();

    $this->assertSame("<ul>
<li>Add <code>label</code> log type</li>
<li>Disable SQL highlighting (-&gt;showQueries() crashed the app because of an issue with the code highlighting)</li>
<li>Fix placeholder blocks in dark mode</li>
<li>Fix window bounds resetting on app boot when it was stickied to a side of the screen</li>
</ul>
", $release->notes_html);
});

