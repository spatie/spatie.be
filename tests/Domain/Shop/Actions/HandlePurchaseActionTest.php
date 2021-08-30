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
use Laravel\Paddle\Receipt;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    parent::setUp();

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

    $this->assertCount(0, $purchase->licenses);
    $this->assertTrue($purchase->user->is($this->user));
    $this->assertTrue($purchase->purchasable->is($purchasable));

    $this->assertCount(1, $purchase->assignments);
    tap($purchase->assignments()->first(), function (PurchaseAssignment $assignment) {
        $this->assertTrue($assignment->user->is($this->user));
    });

    $this->assertEquals($this->receipt->id, $purchase->receipt->id);
    $this->assertEquals($this->payload->fee, $purchase->paddle_fee);
    $this->assertEquals($this->payload->earnings, $purchase->balance_earnings);
    $this->assertEquals($this->payload->toArray(), $purchase->paddle_webhook_payload);

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

    $this->assertCount(3, $purchase->assignments);
    $this->assertCount(3, $purchase->licenses);
    foreach ($purchase->licenses as $license) {
        $this->assertTrue($license->expires_at->isNextYear());
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

    $this->assertCount(1, $purchase->assignments);
    $this->assertCount(3, $purchase->licenses);
    foreach ($purchase->licenses as $license) {
        $this->assertTrue($license->expires_at->isNextYear());
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

    $this->assertCount(1, $purchase->licenses);
    $this->assertTrue($purchase->licenses->first()->expires_at->isNextYear());
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
    $this->assertCount(1, $originalPurchase->licenses);
    $this->assertEquals(
        Date::create(2021, 01, 01),
        $originalPurchase->licenses->first()->fresh()->expires_at
    );

    $this->paddlePayloadAttributes['passthrough'] = json_encode([
        'license_id' => $originalPurchase->licenses->first()->id,
    ]);
    $this->payload = new PaddlePayload($this->paddlePayloadAttributes);

    $this->handlePurchaseAction->execute(
        $this->user,
        $renewalPurchasable,
        $this->payload,
    );

    $this->assertEquals(
        Date::create(2022, 01, 01),
        $originalPurchase->licenses->first()->fresh()->expires_at
    );

    $this->assertEquals(1, License::count());
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

    $this->assertEquals(1, $this->user->licenses()->count());

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    $this->assertEquals(2, $this->user->licenses()->count());
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

    $this->assertNull($this->user->next_purchase_discount_period_ends_at);

    $this->handlePurchaseAction->execute(
        $this->user,
        $purchasable,
        $this->payload
    );

    $this->assertEquals(now()->addDay()->timestamp, $this->user->refresh()->next_purchase_discount_period_ends_at->timestamp);

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

    $this->assertCount(1, $referrer->refresh()->usedForPurchases);
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

    $this->assertCount(1, $this->user->purchases);
    $this->assertCount(1, $this->user->licenses);

    $license = $this->user->licenses->first();
    $this->assertEquals($license->purchasable->id, $rayPurchasable->id);
    $this->assertEquals('2021-01-01 00:00:00', $license->expires_at->format('Y-m-d H:i:s'));
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

    $this->assertCount(1, $this->user->licenses);

    $this->assertEquals('2022-01-01 00:00:00', $existingRayLicense->refresh()->expires_at->format('Y-m-d H:i:s'));
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

    $this->assertCount(0, $purchase->licenses);
    $this->assertTrue($purchase->user->is($this->user));
    $this->assertTrue($purchase->bundle->is($bundle));

    $this->assertEquals($this->receipt->id, $purchase->receipt->id);
    $this->assertEquals($this->payload->fee, $purchase->paddle_fee);
    $this->assertEquals($this->payload->earnings, $purchase->balance_earnings);
    $this->assertEquals($this->payload->toArray(), $purchase->paddle_webhook_payload);

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

    $this->assertCount(2, $purchase->licenses);
    $this->assertCount(2, $this->user->licenses);
    $this->assertTrue($purchase->user->is($this->user));
    $this->assertTrue($purchase->bundle->is($bundle));

    $this->assertTrue($purchase->licenses->first()->expires_at->isNextYear());
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

    $this->assertCount(4, $purchase->assignments);
    $this->assertTrue(User::whereEmail('jane@doe.com')->first()->owns($purchasable1));
    $this->assertTrue(User::whereEmail('jane@doe.com')->first()->owns($purchasable2));
    $this->assertTrue(User::whereEmail('john@doe.com')->first()->owns($purchasable1));
    $this->assertTrue(User::whereEmail('john@doe.com')->first()->owns($purchasable2));
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
