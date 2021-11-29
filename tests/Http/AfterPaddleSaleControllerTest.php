<?php

use App\Domain\Shop\Models\Purchasable;
use App\Http\Controllers\AfterPaddleSaleController;
use App\Models\User;
use Illuminate\Support\Env;

test('the after paddle sale controller is valid', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    /** @var Purchasable $purchasable */
    $purchasable = Purchasable::factory()->create();

    $this
        ->followingRedirects()
        ->get(action(AfterPaddleSaleController::class, [$purchasable->product->slug, $purchasable]))
        ->assertViewIs('front.profile.purchases')
        ->assertSee("'event': 'purchase'", escape: false); // important for Google Analytics
});
