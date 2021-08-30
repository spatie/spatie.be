<?php

use App\Domain\Shop\Models\Purchasable;
use App\Http\Controllers\AfterPaddleSaleController;
use App\Models\User;
use Tests\TestCase;

uses(TestCase::class);

test('the after paddle sale controller is valid', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Purchasable $purchasable */
    $purchasable = Purchasable::factory()->create();

    $this
        ->get(action(AfterPaddleSaleController::class, [$purchasable->product->slug, $purchasable]))
        ->assertRedirect(route('purchases'));
});
