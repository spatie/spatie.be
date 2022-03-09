<?php

use App\Actions\GrantRayTrialLicenseAction;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Mail\RayTrialLicenseGrantedMail;
use App\Models\User;
use Spatie\TestTime\TestTime;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    TestTime::freeze();

    Mail::fake();

    $this->user = User::factory()->create();

    $this->purchasable = Purchasable::factory()->create([
        'title' => 'Ray license',
        'product_id' => Product::factory()->create(['title' => 'Ray'])->id,
    ]);
});

it('will grant a one month trial of Ray', function () {
    app(GrantRayTrialLicenseAction::class)->execute($this->user);

    expect($this->user->owns($this->purchasable))->toBeTrue();

    expect($this->user->licenses)->toHaveCount(1);
    expect($this->user->licenses->first()->expires_at->timestamp)->toEqual(now()->addMonth()->timestamp);

    Mail::assertQueued(RayTrialLicenseGrantedMail::class);
});

it('will grant the trial license only once', function () {
    app(GrantRayTrialLicenseAction::class)->execute($this->user->refresh());
    app(GrantRayTrialLicenseAction::class)->execute($this->user->refresh());
    app(GrantRayTrialLicenseAction::class)->execute($this->user->refresh());

    expect($this->user->licenses)->toHaveCount(1);
});

it('will grant a trial license when having bought another product', function () {
    $assignment = PurchaseAssignment::factory()->create(['user_id' => $this->user->id]);
    expect($this->user->owns($assignment->purchasable))->toBeTrue();

    expect($this->user->licenses)->toHaveCount(0);
    app(GrantRayTrialLicenseAction::class)->execute($this->user->refresh());
    expect($this->user->refresh()->licenses)->toHaveCount(1);
});
