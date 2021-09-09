<?php

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use App\Support\Uuid\Uuid;


test('has completed', function () {
    /** @var \App\Models\Series $series */
    $series = Series::factory()->create();

    $videoA = Video::factory()->make([
        'series_id' => $series->id,
    ]);

    $videoA->saveQuietly();

    $videoB = Video::factory()->make([
        'series_id' => $series->id,
    ]);

    $videoB->saveQuietly();

    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    expect($user->hasCompleted($series))->toBeFalse();

    $user->completeVideo($videoA);

    expect($user->hasCompleted($series))->toBeFalse();

    $user->completeVideo($videoB);

    expect($user->hasCompleted($series))->toBeTrue();
});

test('deleting a user also deletes its purchases and achievements', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    $purchasable = Purchasable::factory()->create();

    Purchase::factory()->create([
        'user_id' => $user->id,
        'purchasable_id' => $purchasable->id,
        'paddle_fee' => 0,
        'earnings' => 0,
        'quantity' => 1,
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

    $this->assertEquals(1, $user->purchases()->count());
    $this->assertEquals(1, $user->achievements()->count());
    $this->assertEquals(1, $user->experience()->count());

    $user->delete();

    $this->assertEquals(0, $user->purchases()->count());
    $this->assertEquals(0, $user->achievements()->count());
    $this->assertEquals(0, $user->experience()->count());
});
