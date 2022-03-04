<?php

use App\Domain\Shop\Models\Release;

beforeEach(function () {
    $this->release = Release::factory()->create([
        'released' => true,
        'notes' => '## Version 0.0.1',
        'version' => '0.0.1',
    ]);
});

it('will return 404 when requesting a non existent version', function () {
    $this
        ->get("/api/releases/{$this->release->product->id}/0.0.2")
        ->assertNotFound();
});

it('will return 404 when requesting a non released version', function () {
    $this->release->update(['released' => false]);

    $this
        ->get("/api/releases/{$this->release->product->id}/0.0.1")
        ->assertNotFound();
});

it('will automatically generated a html version of the notes', function () {
    $this->release->update(['notes' => '## Title']);

    expect($this->release->refresh()->notes_html)->toEqual('<h2 id="a-idtitle-hreftitle-classheading-permalink-titlepermalinkatitle"><a id="title" href="#title" class="heading-permalink" title="Permalink">#</a>Title</h2>' . PHP_EOL);
});
