<?php

use App\Domain\Shop\Actions\HandlePurchaseAction;
use App\Domain\Shop\Actions\RestoreRepositoryAccessAction;
use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Domain\Shop\Models\Referrer;
use App\Domain\Shop\Notifications\AccountHasBeenCreatedNotification;
use App\Mail\PurchaseConfirmationMail;
use App\Models\User;
use App\Support\Paddle\PaddlePayload;
use Database\Factories\ReceiptFactory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\TestTime\TestTime;

beforeEach(function () {
    $this->handlePurchaseAction = resolve(HandlePurchaseAction::class);

    $this->user = User::factory()->create();

    $this->receipt = ReceiptFactory::new()->create();

    $this->paddlePayloadAttributes = [
        'receipt_url' => 'https://spatie.be',
        'payment_method' => 'creditcard',
        'alert_id' => 'fake_alert_id',
        'fee' => 10,
        'payment_tax' => 30,
        'order_id' => $this->receipt->order_id,
        'balance_fee' => 10,
        'balance_earnings' => 10,
    ];

    $this->payload = new PaddlePayload($this->paddlePayloadAttributes);

    EmailList::create(['name' => 'Spatie']);
});

it('can create a purchase without a license', function () {
    Mail::fake();

    $purchasable = Purchasable::factory()->create([
        'requires_license' => false,
    ]);

    $purchase = $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    expect($purchase->licenses)->toHaveCount(0);
    expect($purchase->user->is($this->user))->toBeTrue();
    expect($purchase->purchasable->is($purchasable))->toBeTrue();

    expect($purchase->assignments)->toHaveCount(1);
    tap($purchase->assignments()->first(), function (PurchaseAssignment $assignment) {
        expect($assignment->user->is($this->user))->toBeTrue();
    });

    expect($purchase->receipt->id)->toEqual($this->receipt->id);
    expect($purchase->paddle_fee)->toEqual($this->payload->fee);
    expect($purchase->balance_earnings)->toEqual($this->payload->earnings);
    expect($purchase->paddle_webhook_payload)->toEqual($this->payload->toArray());

    Mail::assertQueued(PurchaseConfirmationMail::class);
});

it('can create a purchase for multiple purchasables at once', function () {
    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $this->paddlePayloadAttributes['quantity'] = 3;
    $this->paddlePayloadAttributes['passthrough'] = json_encode([
        'emails' => [
            'jane@doe.com',
            'john@doe.com',
            'jack@doe.com',
        ],
    ]);
    $this->payload = new PaddlePayload($this->paddlePayloadAttributes);

    $purchase = $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    expect($purchase->assignments)->toHaveCount(3);
    expect($purchase->licenses)->toHaveCount(3);
    foreach ($purchase->licenses as $license) {
        expect($license->expires_at->isNextYear())->toBeTrue();
    }
});

it('creates users that dont have an account yet', function () {
    Notification::fake();

    $purchasable = Purchasable::factory()->create();

    $this->paddlePayloadAttributes['passthrough'] = json_encode([
        'emails' => [
            'jane@doe.com',
        ],
    ]);
    $this->payload = new PaddlePayload($this->paddlePayloadAttributes);

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    $user = User::firstWhere('email', 'jane@doe.com');

    Notification::assertSentTo($user, AccountHasBeenCreatedNotification::class);
});

it('can create a purchase for multiple purchasables at once without assignments', function () {
    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $this->paddlePayloadAttributes['quantity'] = 3;
    $this->payload = new PaddlePayload($this->paddlePayloadAttributes);

    $purchase = $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    expect($purchase->assignments)->toHaveCount(1);
    expect($purchase->licenses)->toHaveCount(3);
    foreach ($purchase->licenses as $license) {
        expect($license->expires_at->isNextYear())->toBeTrue();
    }
});

it('can create a purchase with license', function () {
    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $purchase = $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    expect($purchase->licenses)->toHaveCount(1);
    expect($purchase->licenses->first()->expires_at->isNextYear())->toBeTrue();
});

it('can renew a license', function () {
    Date::setTestNow(Date::create(2020, 01, 01));

    $renewalPurchasable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $purchasable = Purchasable::factory()->create([
        'renewal_purchasable_id' => $renewalPurchasable->id,
        'requires_license' => true,
    ]);

    $originalPurchase = $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );
    expect($originalPurchase->licenses)->toHaveCount(1);

    expect($originalPurchase->licenses->first()->fresh()->expires_at)
        ->toEqual(Date::create(2021, 01, 01));

    $this->paddlePayloadAttributes['passthrough'] = json_encode([
        'license_id' => $originalPurchase->licenses->first()->id,
    ]);
    $this->payload = new PaddlePayload($this->paddlePayloadAttributes);

    $this->handlePurchaseAction->execute(
        $this->user,
        $renewalPurchasable,
        $this->payload,
    );

    expect($originalPurchase->licenses->first()->fresh()->expires_at)
        ->toEqual(Date::create(2022, 01, 01));

    expect(License::count())->toEqual(1);
});

it('creates a new license even if the user already owns the purchasable', function () {
    Date::setTestNow(Date::create(2020, 01, 01));

    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload,
    );

    expect($this->user->licenses()->count())->toEqual(1);

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    expect($this->user->licenses()->count())->toEqual(2);
});

it('restores repository access', function () {
    $spy = $this->spy(RestoreRepositoryAccessAction::class);

    $this->handlePurchaseAction = resolve(HandlePurchaseAction::class);

    $this->user->update(['github_username' => 'username']);

    $purchasable = Purchasable::factory()->create([
        'requires_license' => true,
        'repository_access' => 'spatie/some-repository',
    ]);

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload,
    );

    $spy->shouldHaveReceived('execute')->with($this->user)->once();
});

it('will start the next purchase discount for a user', function () {
    TestTime::freeze();

    Mail::fake();

    $purchasable = Purchasable::factory()->create([
        'requires_license' => false,
    ]);

    expect($this->user->next_purchase_discount_period_ends_at)->toBeNull();

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    expect($this->user->refresh()->next_purchase_discount_period_ends_at->timestamp)->toEqual(now()->addDay()->timestamp);

    Mail::assertQueued(PurchaseConfirmationMail::class);
});

it('can attribute a purchase to a referrer', function () {
    $purchasable = Purchasable::factory()->create([
        'requires_license' => false,
    ]);

    $referrer = Referrer::factory()->create();

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload,
        $referrer
    );

    expect($referrer->refresh()->usedForPurchases)->toHaveCount(1);
});

test('buying certain products will also create a ray license', function () {
    $this->markTestSkipped('unlocksRayLicense is currently disabled.');

    TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

    $product = Product::factory()->create([
       'slug' => 'front-line-php',
    ]);

    $purchasable = Purchasable::factory()->create([
        'requires_license' => false,
        'product_id' => $product->id,
    ]);

    $rayPurchasable = createRayPurchasable();

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    $this->user->refresh();

    expect($this->user->purchases)->toHaveCount(1);
    expect($this->user->licenses)->toHaveCount(1);

    $license = $this->user->licenses->first();
    expect($rayPurchasable->id)->toEqual($license->purchasable->id);
    expect($license->expires_at->format('Y-m-d H:i:s'))->toEqual('2021-01-01 00:00:00');
});

test('buying certain products will extend an existing ray license', function () {
    $this->markTestSkipped('unlocksRayLicense is currently disabled.');

    TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

    $rayPurchasable = createRayPurchasable();

    $existingRayLicense = $this->user->licenses()->create([
        'purchasable_id' => $rayPurchasable->id,
        'key' => 'test_key',
        'expires_at' => now()->addYear(),
    ]);

    $product = Product::factory()->create([
        'slug' => 'front-line-php',
    ]);

    $purchasable = Purchasable::factory()->create([
        'requires_license' => false,
        'product_id' => $product->id,
    ]);

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    $this->user->refresh();

    expect($this->user->licenses)->toHaveCount(1);

    expect($existingRayLicense->refresh()->expires_at->format('Y-m-d H:i:s'))->toEqual('2022-01-01 00:00:00');
});

it('can process a bundle purchase', function () {
    Mail::fake();

    /** @var Bundle $bundle */
    $bundle = Bundle::factory()->create();

    $purchasable1 = Purchasable::factory()->create([
        'requires_license' => false,
    ]);

    $purchasable2 = Purchasable::factory()->create([
        'requires_license' => false,
    ]);

    $bundle->purchasables()->sync([$purchasable1->id, $purchasable2->id]);

    $purchase = $this->handlePurchaseAction->execute(
        $this->user,
        $bundle,
        $this->payload
    );

    expect($purchase->licenses)->toHaveCount(0);
    expect($purchase->user->is($this->user))->toBeTrue();
    expect($purchase->bundle->is($bundle))->toBeTrue();

    expect($purchase->receipt->id)->toEqual($this->receipt->id);
    expect($purchase->paddle_fee)->toEqual($this->payload->fee);
    expect($purchase->balance_earnings)->toEqual($this->payload->earnings);
    expect($purchase->paddle_webhook_payload)->toEqual($this->payload->toArray());

    Mail::assertQueued(PurchaseConfirmationMail::class, 2);
});

it('can process a bundle purchase with licenses', function () {
    Mail::fake();

    /** @var Bundle $bundle */
    $bundle = Bundle::factory()->create();

    $purchasable1 = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $purchasable2 = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $bundle->purchasables()->sync([$purchasable1->id, $purchasable2->id]);

    $purchase = $this->handlePurchaseAction->execute(
        $this->user,
        $bundle,
        $this->payload
    );

    expect($purchase->licenses)->toHaveCount(2);
    expect($this->user->licenses)->toHaveCount(2);
    expect($purchase->user->is($this->user))->toBeTrue();
    expect($purchase->bundle->is($bundle))->toBeTrue();

    expect($purchase->licenses->first()->expires_at->isNextYear())->toBeTrue();
});

it('can process a bundle purchase with licenses for multiple assignments', function () {
    Mail::fake();

    /** @var Bundle $bundle */
    $bundle = Bundle::factory()->create();

    $purchasable1 = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $purchasable2 = Purchasable::factory()->create([
        'requires_license' => true,
    ]);

    $bundle->purchasables()->sync([$purchasable1->id, $purchasable2->id]);

    $this->paddlePayloadAttributes['passthrough'] = json_encode([
        'emails' => [
            'jane@doe.com',
            'john@doe.com',
        ],
    ]);
    $this->payload = new PaddlePayload($this->paddlePayloadAttributes);

    $purchase = $this->handlePurchaseAction->execute(
        $this->user,
        $bundle,
        $this->payload
    );

    expect($purchase->assignments)->toHaveCount(4);
    expect(User::whereEmail('jane@doe.com')->first()->owns($purchasable1))->toBeTrue();
    expect(User::whereEmail('jane@doe.com')->first()->owns($purchasable2))->toBeTrue();
    expect(User::whereEmail('john@doe.com')->first()->owns($purchasable1))->toBeTrue();
    expect(User::whereEmail('john@doe.com')->first()->owns($purchasable2))->toBeTrue();
});

// Helpers
function createRayPurchasable(): Purchasable
{
    $product = Product::factory()->create([
        'slug' => 'ray',
    ]);

    return Purchasable::factory()->create([
        'product_id' => $product->id,
        'type' => 'standard',
    ]);
}
