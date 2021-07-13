<?php

namespace Tests\Domain\Experience;

use App\Domain\Achievements\Models\Achievement;
use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Support\Uuid\Uuid;
use Database\Seeders\AchievementSeeder;
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

    /** @test */
    public function test_100_pull_requests_achievement()
    {
        (new AchievementSeeder())->run();

        $uuid = Uuid::new();

        $bus = app(CommandBus::class);

        foreach (range(1, 100) as $i) {
            $bus->dispatch(new RegisterPullRequest(
                $uuid,
                1,
            ));
        }

        $this->assertDatabaseHas(UserAchievementProjection::class, [
            'user_id' => 1,
            'slug' => '10-pull-requests',
        ]);

        $this->assertDatabaseHas(UserAchievementProjection::class, [
            'user_id' => 1,
            'slug' => '50-pull-requests',
        ]);

        $this->assertDatabaseHas(UserAchievementProjection::class, [
            'user_id' => 1,
            'slug' => '100-pull-requests',
        ]);
    }

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
