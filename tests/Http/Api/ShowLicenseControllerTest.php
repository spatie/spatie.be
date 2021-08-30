<?php

use App\Domain\Shop\Models\License;
use Tests\TestCase;

uses(TestCase::class);

it('can show a license', function () {
    $license = License::factory()->create();

    $this
        ->get("/api/license/{$license->key}")
        ->assertJsonFragment([
            'expires_at' => $license->expires_at->timestamp,
        ]);
});

it('will return 404 for a non existing license', function () {
    $this
        ->get("/api/license/non-existing-key")
        ->assertNotFound();
});
