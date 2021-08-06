<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Events\AchievementUnlocked;
use Database\Factories\AchievementFactory;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Spatie\EventSourcing\StoredEvents\HandleStoredEventJob;
use Tests\TestCase;

class AchievementCertificateTest extends TestCase
{
    /** @test */
    public function certificate_reactor_is_queued()
    {
        $achievement = AchievementFactory::new()->create();

        $user = UserFactory::new()->create();

        Bus::fake();

        command(new UnlockAchievement($user->uuid, $user->id, $achievement));

        Bus::assertDispatched(function (HandleStoredEventJob $job) {
            return $job->storedEvent->event_class === AchievementUnlocked::class;
        });
    }

    /** @test */
    public function certificate_is_stored_on_the_filesystem()
    {
        $achievement = AchievementFactory::new()->create([
            'certificate_template_path' => 'front.achievements.certificatePlaceholder',
        ]);

        $user = UserFactory::new()->create();

        $storage = Storage::fake('public');

        command(new UnlockAchievement($user->uuid, $user->id, $achievement));

        /** @var \App\Domain\Experience\Projections\UserAchievementProjection $userAchievement */
        $userAchievement = $user->achievements()->where('achievement_id', $achievement->id)->first();

        $storage->assertExists($userAchievement->getCertificatePath());
    }

    /** @test */
    public function certificate_is_not_stored_when_no_template_was_set()
    {
        $achievement = AchievementFactory::new()->create([
            'certificate_template_path' => null,
        ]);

        $user = UserFactory::new()->create();

        $storage = Storage::fake('public');

        command(new UnlockAchievement($user->uuid, $user->id, $achievement));

        /** @var \App\Domain\Experience\Projections\UserAchievementProjection $userAchievement */
        $userAchievement = $user->achievements()->where('achievement_id', $achievement->id)->first();

        $storage->assertMissing($userAchievement->getCertificatePath());
    }
}
