<?php

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Domain\Shop\Models\Referrer;
use App\Models\AdminAccess;
use App\Models\Member;
use App\Models\User;
use App\Support\Uuid\Uuid;

it('recognizes only bound allowlisted Spatie accounts as administrators', function (string $email, bool $approved, bool $bound, bool $expected) {
    $user = User::factory()->create(['email' => $email]);

    if ($approved) {
        AdminAccess::create(['email' => strtolower($email), 'user_id' => $bound ? $user->id : null]);
    }

    expect($user->isAdmin())->toBe($expected);
})->with([
    'approved bound account' => ['staff@spatie.be', true, true, true],
    'case-insensitive address' => ['STAFF@SPATIE.BE', true, true, true],
    'unapproved account' => ['staff@spatie.be', false, false, false],
    'pending approval' => ['staff@spatie.be', true, false, false],
    'external bound account' => ['staff@example.com', true, true, false],
    'lookalike domain' => ['staff@spatie.be.example.com', true, true, false],
]);

it('does not recognize unsaved users or users without an email as administrators', function () {
    AdminAccess::create(['email' => 'pending@spatie.be']);

    expect(User::factory()->make(['email' => 'pending@spatie.be'])->isAdmin())->toBeFalse();
    expect(User::factory()->make(['email' => null])->isAdmin())->toBeFalse();
});

it('does not transfer admin access when a bound account changes its email', function () {
    $admin = User::factory()->create(['email' => 'original@spatie.be']);
    AdminAccess::create(['email' => $admin->email, 'user_id' => $admin->id]);
    expect($admin->isAdmin())->toBeTrue();

    $admin->update(['email' => 'changed@spatie.be']);
    $claimant = User::factory()->create(['email' => 'original@spatie.be']);

    expect($admin->isAdmin())->toBeFalse();
    expect($claimant->isAdmin())->toBeFalse();
});

it('requires team membership as well as current approval for staff privileges', function (string $matchedAttribute) {
    $user = User::factory()->create(['github_username' => 'staff-github']);
    $access = AdminAccess::create(['email' => strtolower($user->email), 'user_id' => $user->id]);

    expect($user->isAdmin())->toBeTrue();
    expect($user->isSpatieMember())->toBeFalse();

    Member::factory()->create([$matchedAttribute => $matchedAttribute === 'github' ? $user->github_username : $user->email]);

    expect($user->isSpatieMember())->toBeTrue();
    expect($user->isSponsoring())->toBeTrue();
    expect($user->hasAccessToUnReleasedProducts())->toBeTrue();
    expect($user->canImpersonate())->toBeTrue();

    $access->delete();

    expect($user->isAdmin())->toBeFalse();
    expect($user->isSpatieMember())->toBeFalse();
    expect($user->isSponsoring())->toBeFalse();
    expect($user->hasAccessToUnReleasedProducts())->toBeFalse();
    expect($user->canImpersonate())->toBeFalse();
})->with(['email', 'github']);

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
    $access = AdminAccess::create(['email' => strtolower($user->email), 'user_id' => $user->id, 'google_id' => 'original-google-subject']);

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

    expect($access->fresh()->user_id)->toBeNull();
    expect($access->fresh()->google_id)->toBe('original-google-subject');

    expect($user)
        ->purchases->fresh()->toHaveCount(0)
        ->achievements->fresh()->toHaveCount(0)
        ->licenses->fresh()->toHaveCount(0)
        ->assignments->fresh()->toHaveCount(0)
        ->experience->fresh()->toBeNull();
});
