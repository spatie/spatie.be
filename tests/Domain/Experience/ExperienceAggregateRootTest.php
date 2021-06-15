<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Events\ExperienceEarned;
use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Support\Uuid;
use Spatie\EventSourcing\Commands\CommandBus;
use Tests\Factories\Events\AchievementUnlockedFactory;
use Tests\Factories\Events\ExperienceEarnedFactory;
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
    public function test_100_pull_requests()
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
            'title' => 'Package master!',
        ]);
    }

    /** @test */
    public function test_achievement_for_100_xp()
    {
        $uuid = Uuid::new();

        $experienceEarnedFactory = ExperienceEarnedFactory::new();

        ExperienceAggregateRoot::fake($uuid)
            ->given(
                $experienceEarnedFactory->withAmount(60)->create(),
            )
            ->when(function (ExperienceAggregateRoot $aggregateRoot) use ($uuid) {
                $aggregateRoot->add(
                    new AddExperience($uuid, 'test@spatie.be', ExperienceType::PullRequest())
                );
            })
            ->assertRecorded([
                $experienceEarnedFactory->withAmount(50)->create(),
                AchievementUnlockedFactory::new()->withTitle('100 XP!')->create(),
            ]);
    }
}
