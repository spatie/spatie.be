<?php

namespace Tests\Actions;

use App\Actions\StartOrExtendNextPurchaseDiscountPeriodAction;
use App\Mail\PurchaseConfirmationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class StartOrExtendNextPurchaseDiscountPeriodActionTest extends TestCase
{
    private StartOrExtendNextPurchaseDiscountPeriodAction $action;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        TestTime::freeze();

        Mail::fake();

        $this->user = User::factory()->create();

        $this->action = app(StartOrExtendNextPurchaseDiscountPeriodAction::class);
    }

    /** @test */
    public function it_will_start_the_next_purchase_period_when_a_purchase_has_been_made()
    {
        $this->action->execute($this->user);

        $this->assertEquals(now()->addDay()->timestamp, $this->user->refresh()->next_purchase_discount_period_ends_at->timestamp);
    }

    /** @test */
    public function it_will_extend_an_existing_next_purchase_period()
    {
        $this->action->execute($this->user);

        TestTime::subHours();

        $this->action->execute($this->user);

        $this->assertEquals(now()->addDay()->timestamp, $this->user->refresh()->next_purchase_discount_period_ends_at->timestamp);
    }
}
