<?php

use App\Domain\Shop\Actions\CreateLicenseAction;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use Tests\TestCase;

beforeEach(function () {
    $this->action = resolve(CreateLicenseAction::class);
});

it('can create a license', function () {
    $assignment = PurchaseAssignment::factory()->create();

    $license = $this->action->execute($assignment);

    expect($license)
        ->key->not()->toBeNull()
        ->expires_at->isNextYear()->toBeTrue()
        ->assignment->is($assignment)->toBeTrue();
});

it('can create a license for lifetime purchases', function () {
    $assignment = PurchaseAssignment::factory()->create([
        'purchasable_id' => Purchasable::factory()->create([
            'is_lifetime' => true,
        ])->id,
    ]);

    $license = $this->action->execute($assignment);

    expect($license)
        ->key->not()->toBeNull()
        ->expires_at->year->toBe(2038);
});
