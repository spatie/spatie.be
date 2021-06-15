<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Domain\Experience\UserExperience;
use App\Support\Uuid;
use Tests\TestCase;

class UserExperienceTest extends TestCase
{
    /** @test */
    public function user_experience_can_be_added()
    {
        $uuid = Uuid::new();

        $experience = UserExperience::retrieve($uuid);

        $experience
            ->add(
                email: 'test@spatie.be',
                userId: null,
                type: ExperienceType::PullRequest(),
            )
            ->persist();

        $this->assertDatabaseHas((new UserExperienceProjection())->getTable(), [
            'email' => 'test@spatie.be',
            'amount' => 10,
        ]);
    }
}
