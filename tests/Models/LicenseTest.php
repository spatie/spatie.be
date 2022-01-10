<?php

use App\Domain\Shop\Models\License;

it('can determine that the license does not concern Ray', function() {
    $license = License::factory()->create();

    expect($license->concernsRay())->toBeFalse();
});

it('can determine that the license does concern Ray', function() {
    $license = License::factory()->create();

    $license->assignment->purchasable->product->update(['title' => 'Ray']);

    expect($license->fresh()->concernsRay())->toBeTrue();
});
