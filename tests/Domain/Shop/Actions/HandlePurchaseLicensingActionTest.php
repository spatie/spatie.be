<?php

use App\Domain\Shop\Actions\HandlePurchaseLicensingAction;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use Database\Factories\ReceiptFactory;

beforeEach(function () {
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

it('renews a license', function () {
    $user = User::factory()->create();

    $renewable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);
    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
        'renewal_purchasable_id' => $renewable->id,
    ]);


    $originalPurchase = Purchase::factory()->create([
        'purchasable_id' => $purchasable->id,
        'user_id' => $user->id,
    ]);

    $assignment = PurchaseAssignment::create([
        'user_id' => $user->id,
        'purchasable_id' => $purchasable->id,
        'purchase_id' => $originalPurchase->id,
    ]);

    $license = License::factory()->create([
        'purchase_assignment_id' => $assignment->id,
        'expires_at' => now()->subDay(),
    ]);

    $purchase = Purchase::factory()->create([
        'purchasable_id' => $renewable->id,
        'user_id' => $user->id,
        'passthrough' => [
            'license_id' => $license->id,
        ],
    ]);

    PurchaseAssignment::create([
        'user_id' => $user->id,
        'purchasable_id' => $renewable->id,
        'purchase_id' => $purchase->id,
    ]);

    $this->action->execute($purchase);

    $this->assertTrue($license->fresh()->expires_at > now());
});

it('finds a license to renew if none was passed through', function () {
    $user = User::factory()->create();

    $renewable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);
    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
        'renewal_purchasable_id' => $renewable->id,
    ]);


    $originalPurchase = Purchase::factory()->create([
        'purchasable_id' => $purchasable->id,
        'user_id' => $user->id,
    ]);

    $assignment = PurchaseAssignment::create([
        'user_id' => $user->id,
        'purchasable_id' => $purchasable->id,
        'purchase_id' => $originalPurchase->id,
    ]);

    $license1 = License::factory()->create([
        'purchase_assignment_id' => $assignment->id,
        'expires_at' => now()->subDay(),
    ]);

    $license2 = License::factory()->create([
        'purchase_assignment_id' => $assignment->id,
        'expires_at' => now()->subDays(2),
    ]);

    $purchase = Purchase::factory()->create([
        'purchasable_id' => $renewable->id,
        'user_id' => $user->id,
    ]);

    PurchaseAssignment::create([
        'user_id' => $user->id,
        'purchasable_id' => $renewable->id,
        'purchase_id' => $purchase->id,
    ]);

    $this->action->execute($purchase);

    $this->assertTrue($license1->fresh()->expires_at->isSameDay(now()->subDay()));
    $this->assertTrue($license2->fresh()->expires_at > now());
});

it('throws if it cannot find a license', function () {
    $user = User::factory()->create();

    $renewable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);
    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
        'renewal_purchasable_id' => $renewable->id,
    ]);

    $originalPurchase = Purchase::factory()->create([
        'purchasable_id' => $purchasable->id,
        'user_id' => $user->id,
    ]);

    $assignment = PurchaseAssignment::create([
        'user_id' => $user->id,
        'purchasable_id' => $purchasable->id,
        'purchase_id' => $originalPurchase->id,
    ]);

    $purchase = Purchase::factory()->create([
        'purchasable_id' => $renewable->id,
        'user_id' => $user->id,
    ]);

    PurchaseAssignment::create([
        'user_id' => $user->id,
        'purchasable_id' => $renewable->id,
        'purchase_id' => $purchase->id,
    ]);

    $this->expectExceptionMessage("Could not find a license to renew for purchase id `{$purchase->id}`");

    $this->action->execute($purchase);
});
