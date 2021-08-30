<?php

use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Projectors\UserExperienceProjector;
use App\Models\User;
use Tests\TestCase;

test('on experience earned', function () {
    $user = User::factory()->create();

    $event = new ExperienceEarned($user->id, 10);

    $projector = app(UserExperienceProjector::class);

    $projector->onExperienceEarned($event);

    expect($user->refresh()->experience->amount)->toEqual(10);
});
