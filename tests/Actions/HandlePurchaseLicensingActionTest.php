<?php

namespace Tests\Actions;

use App\Actions\HandlePurchaseLicensingAction;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use Database\Factories\ReceiptFactory;
use Tests\TestCase;

class HandlePurchaseLicensingActionTest extends TestCase
{
    private HandlePurchaseLicensingAction $action;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = resolve(HandlePurchaseLicensingAction::class);
    }

    /** @test * */
    public function it_throws_when_a_purchase_already_has_a_license()
    {
        $purchase = Purchase::make([
            'id' => 1,
            'license_id' => 1,
        ]);

        $this->expectExceptionMessage("Purchase {$purchase->id} already has a license ({$purchase->license_id})");

        $this->action->execute($purchase);
    }

    /** @test * */
    public function it_throws_when_renewing_a_purchasable_that_the_user_doesnt_own()
    {
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

        $this->expectExceptionMessage("User {$user->id} doesn't own purchasable {$purchasable->id} to renew.");

        $this->action->execute($purchase);
    }
}
