<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Commands\SaveAchievementOgImage;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Jobs\GenerateOgImageJob;
use App\Models\User;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class AchievementOgImageReactor extends Reactor
{
    public function __invoke(AchievementUnlocked $event): void
    {
        $user = User::query()->where('id', $event->userId)->firstOrFail();

        /** @var \App\Domain\Experience\Projections\UserAchievementProjection $userAchievement */
        $userAchievement = $user->achievements()->where('slug', $event->slug)->firstOrFail();

        $path = $userAchievement->getOgImagePath();

        dispatch(new GenerateOgImageJob($user, $userAchievement, $path));

        command(SaveAchievementOgImage::forUser(
            user: $user,
            userAchievement: $userAchievement,
            imagePath: $path,
        ));
    }
}
