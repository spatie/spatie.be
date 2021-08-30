<?php

use App\Domain\Shop\Models\Release;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    parent::setUp();

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

    $this->assertEquals('<h2>Title</h2>' . PHP_EOL, $this->release->refresh()->notes_html);
});
