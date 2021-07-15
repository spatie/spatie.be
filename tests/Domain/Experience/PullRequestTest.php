<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Enums\ExperienceType;
use App\Domain\Experience\Events\PullRequestMerged;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\User;
use App\Support\Uuid\Uuid;
use Database\Seeders\AchievementSeeder;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use Tests\TestCase;

class PullRequestTest extends TestCase
{
    /** @test */
    public function experience_is_earned_with_every_pull_request()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        command(RegisterPullRequest::forUser($user, 'pr'));

        $this->assertEquals(ExperienceType::PullRequest()->getAmount(), $user->experience->amount);
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
                Uuid::new(),
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
    public function same_pr_cant_be_registered_twice()
    {
        $bus = app(CommandBus::class);

        foreach (range(1, 2) as $i) {
            $bus->dispatch(new RegisterPullRequest(
                'same-uuid',
                1,
                'TEST',
            ));
        }

        $this->assertEquals(1, EloquentStoredEvent::query()->whereEvent(PullRequestMerged::class)->count());
    }
}
