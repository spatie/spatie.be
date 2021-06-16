<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Domain\Experience\ValueObjects\UserExperienceId;
use App\Support\Uuid;
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
            'test@spatie.be',
            ExperienceType::PullRequest()
        ));

        $this->assertDatabaseHas((new UserExperienceProjection())->getTable(), [
            'email' => 'test@spatie.be',
            'amount' => ExperienceType::PullRequest()->getAmount(),
        ]);
    }

    /** @test */
    public function test_unlock_achievement()
    {
        $uuid = Uuid::new();

        $bus = app(CommandBus::class);

        $bus->dispatch(new UnlockAchievement(
            $uuid,
            'test@spatie.be',
            'A'
        ));

        $this->assertDatabaseHas((new UserAchievementProjection())->getTable(), [
            'email' => 'test@spatie.be',
            'title' => 'A',
        ]);
    }

    /** @test */
    public function test_100_pull_requests_achievement()
    {
        $uuid = Uuid::new();

        $bus = app(CommandBus::class);

        foreach (range(1, 100) as $i) {
            $bus->dispatch(new RegisterPullRequest(
                $uuid,
                'test@spatie.be',
            ));
        }

        $this->assertDatabaseHas((new UserAchievementProjection())->getTable(), [
            'email' => 'test@spatie.be',
            'slug' => '10-pull-requests',
        ]);

        $this->assertDatabaseHas((new UserAchievementProjection())->getTable(), [
            'email' => 'test@spatie.be',
            'slug' => '50-pull-requests',
        ]);

        $this->assertDatabaseHas((new UserAchievementProjection())->getTable(), [
            'email' => 'test@spatie.be',
            'slug' => '100-pull-requests',
        ]);
    }

    /** @test */
    public function test_100_xp_achievement()
    {
        $uuid = Uuid::new();

        $bus = app(CommandBus::class);

        foreach (range(1, 2) as $i) {
            $bus->dispatch(new AddExperience(
                $uuid,
                new UserExperienceId('test@spatie.be'),
                ExperienceType::PullRequest(),
            ));
        }

        $this->assertDatabaseHas((new UserAchievementProjection())->getTable(), [
            'email' => 'test@spatie.be',
            'slug' => '100-experience',
        ]);
    }
}
