<?php

namespace Tests\Jobs;

use App\Models\Purchasable;
use App\Models\Referrer;
use App\Models\User;
use App\Support\Paddle\ProcessPaymentSucceededJob;
use Database\Factories\ReceiptFactory;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

class ProcessPaymentSucceededJobTest extends TestCase
{
    private User $user;

    private array $payload;

    public function setUp(): void
    {
        parent::setUp();

        $receipt = ReceiptFactory::new()->create();

        $purchasable = Purchasable::factory()->create([
            'paddle_product_id' => 123,
        ]);

        $this->user = User::factory()->create();

        EmailList::create(['name' => 'Spatie']);

        $this->payload = [
            'product_id' => $purchasable->paddle_product_id,
            'receipt_url' => 'https://spatie.be',
            'payment_method' => 'creditcard',
            'alert_id' => 'fake_alert_id',
            'alert_name' => 'payment_succeeded',
            'fee' => 10,
            'payment_tax' => 30,
            'order_id' => $receipt->order_id,
            'balance_fee' => 10,
            'balance_earnings' => 10,
            'passthrough' => json_encode([
                'billable_type' => get_class($this->user),
                'billable_id' => $this->user->id,
            ]),
        ];
    }

    /** @test */
    public function it_can_handle_an_incoming_payment()
    {
        $this->assertCount(0, $this->user->refresh()->purchases);

        dispatch(new ProcessPaymentSucceededJob($this->payload));

        $this->assertCount(1, $this->user->refresh()->purchases);
    }

    /** @test */
    public function it_can_attribute_the_purchase_created_by_the_webhook_to_the_referrer()
    {
        /** @var Referrer $referrer */
        $referrer = Referrer::factory()->create();

        $this->payload['passthrough'] = json_encode([
            'billable_type' => get_class($this->user),
            'billable_id' => $this->user->id,
            'referrer_uuid' => $referrer->uuid,
        ]);

        dispatch(new ProcessPaymentSucceededJob($this->payload));

        $this->assertCount(1, $referrer->refresh()->usedForPurchases);
    }

    /** @test */
    public function it_will_ignore_an_invalid_referrer()
    {
        /** @var Referrer $referrer */
        $referrer = Referrer::factory()->create();

        $this->payload['passthrough'] = json_encode([
            'billable_type' => get_class($this->user),
            'billable_id' => $this->user->id,
            'referrer_uuid' => 'invalid-uuid',
        ]);

        dispatch(new ProcessPaymentSucceededJob($this->payload));

        $this->assertCount(1, $this->user->refresh()->purchases);

        $this->assertCount(0, $referrer->refresh()->usedForPurchases);
    }
}
