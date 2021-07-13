<?php

namespace Tests\Domain\Experience\Projectors;

use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\Projectors\UserExperienceProjector;
use App\Models\User;
use Tests\TestCase;

class UserExperienceProjectorTest extends TestCase
{
    /** @test */
    public function on_experience_earned()
    {
        $user = User::factory()->create();

        $event = new ExperienceEarned($user->id, 10);

        $projector = app(UserExperienceProjector::class);

        $projector->onExperienceEarned($event);

        $this->assertEquals(10, $user->refresh()->experience->amount);
    }
}
