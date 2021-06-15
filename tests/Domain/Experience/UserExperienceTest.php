<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Commands\AddUserExperience;
use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Domain\Experience\UserExperience;
use App\Support\Uuid;
use Spatie\EventSourcing\Commands\CommandBus;
use Tests\TestCase;

class UserExperienceTest extends TestCase
{
    /** @test */
    public function user_experience_can_be_added()
    {
        $uuid = Uuid::new();

        $bus = app(CommandBus::class);

        $bus->dispatch(new AddUserExperience(
            uuid: $uuid,
            email: 'test@spatie.be',
            type: ExperienceType::PullRequest(),
        ));

        $this->assertDatabaseHas((new UserExperienceProjection())->getTable(), [
            'email' => 'test@spatie.be',
            'amount' => 10,
        ]);
    }
}
