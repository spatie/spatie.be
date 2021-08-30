<?php

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;
use App\Models\User;
use App\Support\Paddle\ProcessPaymentSucceededJob;
use Database\Factories\ReceiptFactory;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

uses(TestCase::class);
use function dispatch;

beforeEach(function () {
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
});

it('can handle an incoming payment', function () {
    $this->assertCount(0, $this->user->refresh()->purchases);

    dispatch(new ProcessPaymentSucceededJob($this->payload));

    $this->assertCount(1, $this->user->refresh()->purchases);
});

it('can handle an incoming bundle payment', function () {
    $this->markTestSkipped('To fix');

    $bundle = Bundle::factory()->create([
        'paddle_product_id' => 123,
    ]);

    $bundle->purchasables()->attach(Purchasable::factory()->create());

    $payload = $this->payload;
    $payload['product_id'] = 123;

    $this->assertCount(0, $this->user->refresh()->purchases);

    dispatch(new ProcessPaymentSucceededJob($payload));

    $this->assertCount(1, $this->user->refresh()->purchases);
    $this->assertNotNull($this->user->refresh()->purchases->first()->bundle_id);
});

it('can attribute the purchase created by the webhook to the referrer', function () {
    /** @var Referrer $referrer */
    $referrer = Referrer::factory()->create();

    $this->payload['passthrough'] = json_encode([
        'billable_type' => get_class($this->user),
        'billable_id' => $this->user->id,
        'referrer_uuid' => $referrer->uuid,
    ]);

    dispatch(new ProcessPaymentSucceededJob($this->payload));

    $this->assertCount(1, $referrer->refresh()->usedForPurchases);
});

it('will ignore an invalid referrer', function () {
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
});
