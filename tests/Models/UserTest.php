<?php

use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use Tests\TestCase;

uses(TestCase::class);

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
