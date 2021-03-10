<?php

namespace Tests\Actions;

use App\Actions\HandlePurchaseAction;
use App\Actions\RestoreRepositoryAccessAction;
use App\Mail\PurchaseConfirmationMail;
use App\Models\License;
use App\Models\Product;
use App\Models\Purchasable;
use App\Models\Referrer;
use App\Models\User;
use App\Support\Paddle\PaddlePayload;
use Database\Factories\ReceiptFactory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Laravel\Paddle\Receipt;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class HandlePurchaseActionTest extends TestCase
{
    protected HandlePurchaseAction $handlePurchaseAction;

    protected User $user;

    protected Receipt $receipt;

    protected array $paddlePayloadAttributes;

    protected PaddlePayload $payload;

    protected function setUp(): void
    {
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
    }

    /** @test */
    public function it_can_create_a_purchase_without_a_license()
    {
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

        $this->assertEquals($this->receipt->id, $purchase->receipt->id);
        $this->assertEquals($this->payload->fee, $purchase->paddle_fee);
        $this->assertEquals($this->payload->earnings, $purchase->balance_earnings);
        $this->assertEquals($this->payload->toArray(), $purchase->paddle_webhook_payload);

        Mail::assertQueued(PurchaseConfirmationMail::class);
    }

    /** @test */
    public function it_can_create_a_purchase_for_multiple_purchasables_at_once()
    {
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

        $this->assertCount(3, $purchase->licenses);
        foreach ($purchase->licenses as $license) {
            $this->assertTrue($license->expires_at->isNextYear());
        }
    }

    /** @test */
    public function it_can_create_a_purchase_with_license()
    {
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
    }

    /** @test */
    public function it_can_renew_a_license()
    {
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
    }

    /** @test */
    public function it_creates_a_new_license_even_if_the_user_already_owns_the_purchasable()
    {
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
    }

    /** @test */
    public function it_restores_repository_access()
    {
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
    }

    /** @test */
    public function it_will_start_the_next_purchase_discount_for_a_user()
    {
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
    }

    /** @test */
    public function it_can_attribute_a_purchase_to_a_referrer()
    {
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
    }

    /** @test */
    public function buying_certain_products_will_also_create_a_ray_license()
    {
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $product = Product::factory()->create([
           'slug' => 'front-line-php',
        ]);

        $purchasable = Purchasable::factory()->create([
            'requires_license' => false,
            'product_id' => $product->id,
        ]);

        $rayPurchasable = $this->createRayPurchasable();

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
    }

    /** @test */
    public function buying_certain_products_will_extend_an_existing_ray_license()
    {
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $rayPurchasable = $this->createRayPurchasable();

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
    }

    protected function createRayPurchasable(): Purchasable
    {
        $product = Product::factory()->create([
            'slug' => 'ray',
        ]);

        return Purchasable::factory()->create([
            'product_id' => $product->id,
            'type' => 'standard',
        ]);
    }
}
