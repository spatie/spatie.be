<?php

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;
use App\Models\User;
use App\Support\Paddle\ProcessPaymentSucceededJob;
use Database\Factories\ReceiptFactory;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;



beforeEach(function () {

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
    expect($this->user->refresh()->purchases)->toHaveCount(0);

    dispatch(new ProcessPaymentSucceededJob($this->payload));

    expect($this->user->refresh()->purchases)->toHaveCount(1);
});

it('can handle an incoming bundle payment', function () {
    $this->markTestSkipped('To fix');

    $bundle = Bundle::factory()->create([
        'paddle_product_id' => 123,
    ]);

    $bundle->purchasables()->attach(Purchasable::factory()->create());

    $payload = $this->payload;
    $payload['product_id'] = 123;

    expect($this->user->refresh()->purchases)->toHaveCount(0);

    dispatch(new ProcessPaymentSucceededJob($payload));

    expect($this->user->refresh()->purchases)->toHaveCount(1);
    expect($this->user->refresh()->purchases->first()->bundle_id)->not()->toBeNull();
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

    expect($referrer->refresh()->usedForPurchases)->toHaveCount(1);
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

    expect($this->user->refresh()->purchases)->toHaveCount(1);

    expect($referrer->refresh()->usedForPurchases)->toHaveCount(0);
});
