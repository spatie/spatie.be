<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Support\Uuid\Uuid;
use Database\Seeders\AchievementSeeder;
use Spatie\EventSourcing\Commands\CommandBus;
use Tests\TestCase;

class ExperienceTest extends TestCase
{
    /** @test */
    public function test_100_xp_achievement()
    {
        (new AchievementSeeder())->run();

        $uuid = Uuid::new();

        $bus = app(CommandBus::class);

        foreach (range(1, 2) as $i) {
            $bus->dispatch(new AddExperience(
                $uuid,
                1,
                50,
            ));
        }

        $this->assertDatabaseHas(UserAchievementProjection::class, [
            'user_id' => 1,
            'slug' => '100-experience',
        ]);

        $this->assertDatabaseMissing(UserAchievementProjection::class, [
            'user_id' => 1,
            'slug' => '1000-experience',
        ]);
    }
}
