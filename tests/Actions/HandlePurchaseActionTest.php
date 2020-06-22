<?php

namespace Tests\Actions;

use App\Actions\HandlePurchaseAction;
use App\Models\Purchasable;
use App\Models\User;
use App\Support\Paddle\PaddlePayload;
use Tests\TestCase;

class HandlePurchaseActionTest extends TestCase
{
    private HandlePurchaseAction $action;

    private User $user;

    private PaddlePayload $payload;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = resolve(HandlePurchaseAction::class);

        $this->user = factory(User::class)->create();

        $this->payload = new PaddlePayload([
            'receipt_url' => 'https://spatie.be',
            'payment_method' => 'creditdard',
            'alert_id' => 'fake_alert_id',
            'fee' => 10,
            'payment_tax' => 30,
            'earnings' => 60,
        ]);
    }

    /** @test */
    public function it_can_create_a_purchase()
    {
        $purchasable = factory(Purchasable::class)->create([
            'requires_license' => false,
        ]);

        $purchase = $this->action->execute(
            $this->user,
            $purchasable,
            $this->payload
        );

        $this->assertNull($purchase->license);
        $this->assertTrue($purchase->user->is($this->user));
        $this->assertTrue($purchase->purchasable->is($this->purchasable));

        $this->assertEquals($this->payload->receipt_url, $purchase->receipt_url);
        $this->assertEquals($this->payload->payment_method, $purchase->payment_method);
        $this->assertEquals($this->payload->alert_id, $purchase->paddle_alert_id);
        $this->assertEquals($this->payload->fee, $purchase->paddle_fee);
        $this->assertEquals($this->payload->payment_tax, $purchase->payment_tax);
        $this->assertEquals($this->payload->earnings, $purchase->earnings);
        $this->assertEquals($this->payload->toArray(), $purchase->paddle_webhook_payload);
    }

    /** @test */
    public function it_can_create_a_purchase_with_license()
    {
        $purchasable = factory(Purchasable::class)->create([
            'requires_license' => true,
        ]);

        $purchase = $this->action->execute(
            $this->user,
            $purchasable,
            $this->payload
        );

        $this->assertNotNull($purchase->license);
        $this->assertTrue($purchase->license->expires_at->isNextYear());
    }
}
