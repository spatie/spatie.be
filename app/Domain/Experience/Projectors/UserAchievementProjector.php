<?php

namespace App\Domain\Experience\Projectors;

use App\Domain\Experience\Events\AchievementCertificateSaved;
use App\Domain\Experience\Events\AchievementOgImageSaved;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Support\Uuid\Uuid;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserAchievementProjector extends Projector
{
    public function onAchievementUnlocked(AchievementUnlocked $event): void
    {
        UserAchievementProjection::new()
            ->writeable()
            ->create([
                'uuid' => (string) Uuid::new(),
                'user_id' => $event->userId,
                'achievement_id' => $event->achievementId,
                'slug' => $event->slug,
                'title' => $event->title,
                'description' => $event->description,
            ]);
    }

    public function onAchievementOgImageSaved(AchievementOgImageSaved $event): void
    {
        UserAchievementProjection::query()->where('uuid', $event->userAchievementUuid)->first()
            ->writeable()
            ->update([
                'og_image_path' => $event->imagePath,
            ]);
    }

    public function onAchievementCertificateSaved(AchievementCertificateSaved $event): void
    {
        UserAchievementProjection::query()->where('uuid', $event->userAchievementUuid)->first()
            ->writeable()
            ->update([
                'certificate_path' => $event->certificatePath,
            ]);
    }
}
