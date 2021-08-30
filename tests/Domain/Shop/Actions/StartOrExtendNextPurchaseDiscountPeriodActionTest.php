<?php

use App\Domain\Shop\Actions\StartOrExtendNextPurchaseDiscountPeriodAction;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\TestTime\TestTime;
use Tests\TestCase;



beforeEach(function () {

    TestTime::freeze();

    Mail::fake();

    $this->user = User::factory()->create();

    $this->action = app(StartOrExtendNextPurchaseDiscountPeriodAction::class);
});

it('will start the next purchase period when a purchase has been made', function () {
    $this->action->execute($this->user);

    expect($this->user->refresh()->next_purchase_discount_period_ends_at->timestamp)->toEqual(now()->addDay()->timestamp);
});

it('will extend an existing next purchase period', function () {
    $this->action->execute($this->user);

    TestTime::subHours();

    $this->action->execute($this->user);

    expect($this->user->refresh()->next_purchase_discount_period_ends_at->timestamp)->toEqual(now()->addDay()->timestamp);
});
