<?php

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Domain\Shop\Models\Referrer;
use App\Models\User;
use App\Support\Uuid\Uuid;

it('can get passthrough for paddle', function () {
    $user = User::factory()->create();

    expect($user->getPassthrough())->toEqual([
        'emails' => [$user->email],
        'billable_id' => $user->id,
        'billable_type' => User::class,
    ]);
});

it('can get passthrough for paddle with a license', function () {
    $user = User::factory()->create();
    $license = License::factory()->create();

    expect($user->getPassthrough($license))->toEqual([
        'emails' => [$user->email],
        'billable_id' => $user->id,
        'billable_type' => User::class,
        'license_id' => $license->id,
    ]);
});

it('can get passthrough for paddle with a license and active referrer', function () {
    $user = User::factory()->create();
    $license = License::factory()->create();
    $referrer = Referrer::factory()->create();
    $referrer->makeActive();

    expect($user->getPassthrough($license))->toEqual([
        'emails' => [$user->email],
        'billable_id' => $user->id,
        'billable_type' => User::class,
        'referrer_uuid' => $referrer->uuid,
        'license_id' => $license->id,
    ]);
});

test('deleting a user also deletes its purchases assignments licenses and achievements', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    $purchasable = Purchasable::factory()->create();

    $purchase = Purchase::factory()->create([
        'user_id' => $user->id,
        'purchasable_id' => $purchasable->id,
        'paddle_fee' => 0,
        'earnings' => 0,
        'quantity' => 1,
    ]);
    $assignment = PurchaseAssignment::factory()->create([
        'user_id' => $user->id,
        'purchasable_id' => $purchasable->id,
        'purchase_id' => $purchase->id,
    ]);
    $license = License::factory()->create([
        'purchase_assignment_id' => $assignment->id,
    ]);

    $achievement = Achievement::factory()->create();

    UserAchievementProjection::new()->writeable()->create([
        'uuid' => Uuid::new(),
        'achievement_id' => $achievement->id,
        'user_id' => $user->id,
        'slug' => $achievement->slug,
        'description' => $achievement->description,
        'title' => $achievement->title,
    ]);

    command(RegisterPullRequest::forUser($user, "PR 1"));

    expect($user)
        ->purchases->toHaveCount(1)
        ->achievements->toHaveCount(1)
        ->assignments->toHaveCount(1)
        ->licenses->toHaveCount(1)
        ->experience->not()->toBeNull();

    $user->delete();

    expect($user)
        ->purchases->fresh()->toHaveCount(0)
        ->achievements->fresh()->toHaveCount(0)
        ->licenses->fresh()->toHaveCount(0)
        ->assignments->fresh()->toHaveCount(0)
        ->experience->fresh()->toBeNull();
});
