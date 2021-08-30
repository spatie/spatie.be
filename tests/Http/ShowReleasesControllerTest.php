<?php

use App\Domain\Shop\Models\Release;
use Tests\TestCase;

uses(TestCase::class);

it('can show the release notes of a product', function () {
    $release = Release::factory()->create();

    $this
        ->get(route('product.releaseNotes', $release->product))
        ->assertSuccessful()
        ->assertSee($release->version);
});
