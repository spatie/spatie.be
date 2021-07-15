<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Support\Uuid\Uuid;
use Spatie\EventSourcing\Commands\CommandBus;
use Tests\TestCase;

class ExperienceAggregateRootTest extends TestCase
{
    /** @test */
    public function test_add()
    {
        $uuid = Uuid::new();

        $bus = app(CommandBus::class);

        $bus->dispatch(new AddExperience(
            $uuid,
            1,
            50
        ));

        $this->assertDatabaseHas((new UserExperienceProjection())->getTable(), [
            'user_id' => 1,
            'amount' => 50,
        ]);
    }

    /** @test */
    public function test_unlock_achievement()
    {
        $uuid = Uuid::new();

        $bus = app(CommandBus::class);

        $bus->dispatch(new UnlockAchievement(
            $uuid,
            1,
            Achievement::factory()->create()
        ));

        $this->assertDatabaseHas((new UserAchievementProjection())->getTable(), [
            'user_id' => 1,
            'title' => 'test',
        ]);
    }
}
