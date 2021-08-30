<?php

use App\Domain\Shop\Actions\HandlePurchaseLicensingAction;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use Database\Factories\ReceiptFactory;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    parent::setUp();

    $this->action = resolve(HandlePurchaseLicensingAction::class);
});

it('throws when renewing a purchasable that the user doesnt own', function () {
    $user = User::factory()->create();

    $renewable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);
    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
        'renewal_purchasable_id' => $renewable->id,
    ]);

    $purchase = Purchase::create([
        'id' => 1,
        'purchasable_id' => $renewable->id,
        'user_id' => $user->id,
        'receipt_id' => $user->receipts()->create(ReceiptFactory::new()->make()->toArray())->id,
        'paddle_webhook_payload' => [],
        'paddle_fee' => 0,
        'earnings' => 0,
    ]);

    PurchaseAssignment::create([
        'user_id' => $user->id,
        'purchasable_id' => $renewable->id,
        'purchase_id' => $purchase->id,
    ]);

    $this->expectExceptionMessage("User {$user->id} doesn't own purchasable {$purchasable->id} to renew.");

    $this->action->execute($purchase);
});
