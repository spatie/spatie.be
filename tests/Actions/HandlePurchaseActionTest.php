<?php

namespace Tests\Actions;

use App\Actions\HandlePurchaseAction;
use App\Actions\RestoreRepositoryAccessAction;
use App\Mail\NextPurchaseDiscountPeriodStartedMail;
use App\Models\License;
use App\Models\Purchasable;
use App\Models\Referrer;
use App\Models\User;
use App\Support\Paddle\PaddlePayload;
use Database\Factories\ReceiptFactory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Laravel\Paddle\Receipt;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class HandlePurchaseActionTest extends TestCase
{
    private HandlePurchaseAction $action;

    private User $user;

    private Receipt $receipt;

    private PaddlePayload $payload;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = resolve(HandlePurchaseAction::class);

        $this->user = User::factory()->create();

        $this->receipt = ReceiptFactory::new()->create();

        $this->payload = new PaddlePayload([
            'receipt_url' => 'https://spatie.be',
            'payment_method' => 'creditcard',
            'alert_id' => 'fake_alert_id',
            'fee' => 10,
            'payment_tax' => 30,
            'order_id' => $this->receipt->order_id,
            'balance_fee' => 10,
            'balance_earnings' => 10,
        ]);

        EmailList::create(['name' => 'Spatie']);
    }

    /** @test */
    public function it_can_create_a_purchase()
    {
        $purchasable = Purchasable::factory()->create([
            'requires_license' => false,
        ]);

        $purchase = $this->action->execute(
            $this->user,
            $purchasable,
            $this->payload
        );

        $this->assertNull($purchase->license);
        $this->assertTrue($purchase->user->is($this->user));
        $this->assertTrue($purchase->purchasable->is($purchasable));

        $this->assertEquals($this->receipt->id, $purchase->receipt->id);
        $this->assertEquals($this->payload->fee, $purchase->paddle_fee);
        $this->assertEquals($this->payload->earnings, $purchase->balance_earnings);
        $this->assertEquals($this->payload->toArray(), $purchase->paddle_webhook_payload);
    }

    /** @test */
    public function it_can_create_a_purchase_with_license()
    {
        $purchasable = Purchasable::factory()->create([
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

        $purchase = $this->action->execute(
            $this->user,
            $purchasable,
            $this->payload,
        );

        $license = $purchase->license;

        $this->assertEquals(Date::create(2021, 01, 01), $license->fresh()->expires_at);

        $this->action->execute(
            $this->user,
            $renewalPurchasable,
            $this->payload
        );

        $this->assertEquals(Date::create(2022, 01, 01), $license->fresh()->expires_at);
        $this->assertEquals(1, License::count());
    }

    /** @test */
    public function it_creates_a_new_license_even_if_the_user_already_owns_the_purchasable()
    {
        Date::setTestNow(Date::create(2020, 01, 01));

        $purchasable = Purchasable::factory()->create([
            'requires_license' => true,
        ]);

        $this->action->execute(
            $this->user,
            $purchasable,
            $this->payload,
        );

        $this->assertEquals(1, $this->user->licenses()->count());

        $this->action->execute(
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

        $this->action = resolve(HandlePurchaseAction::class);

        $this->user->update(['github_username' => 'username']);

        $purchasable = Purchasable::factory()->create([
            'requires_license' => true,
            'repository_access' => 'spatie/some-repository',
        ]);

        $this->action->execute(
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

        $this->action->execute(
            $this->user,
            $purchasable,
            $this->payload
        );

        $this->assertEquals(now()->addDay()->timestamp, $this->user->refresh()->next_purchase_discount_period_ends_at->timestamp);

        Mail::assertQueued(NextPurchaseDiscountPeriodStartedMail::class);
    }

    /** @test */
    public function it_can_attribute_a_purchase_to_a_referrer()
    {
        $purchasable = Purchasable::factory()->create([
            'requires_license' => false,
        ]);

        $referrer = Referrer::factory()->create();

        $this->action->execute(
            $this->user,
            $purchasable,
            $this->payload,
            $referrer
        );

        $this->assertCount(1, $referrer->refresh()->usedForPurchases);
    }
}
