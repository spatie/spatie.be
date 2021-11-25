<?php

use App\Domain\Shop\Actions\TransferPurchaseToUser;
use App\Domain\Shop\Models\Purchase;
use App\Models\User;

it('can transfer purchases to another user', function() {
    $purchase = Purchase::factory()->create();
    $otherUser = User::factory()->create();

    (new TransferPurchaseToUser())->execute($purchase, $otherUser);
    expect($purchase->user_id)->toBe($otherUser->id);
    expect($purchase->assignments)->each->user_id->toBe($otherUser->id);
});
