<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Commands\SaveAchievementCertificate;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\User;
use App\Support\Browsershot\Browsershot;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class AchievementCertificateReactor extends Reactor implements ShouldQueue
{
    public function __construct(private Browsershot $browsershot)
    {
    }

    public function __invoke(AchievementUnlocked $event): void
    {
        $user = User::query()->where('id', $event->userId)->firstOrFail();

        /** @var \App\Domain\Experience\Projections\UserAchievementProjection $userAchievement */
        $userAchievement = $user->achievements()->where('slug', $event->slug)->firstOrFail();

        if ($userAchievement->achievement->certificate_template_path === null) {
            return;
        }

        $this->generateCertificate($userAchievement);

        command(SaveAchievementCertificate::forUserAchievement(
            userAchievement: $userAchievement,
        ));
    }

    private function generateCertificate(
        UserAchievementProjection $userAchievement,
    ) {
        Storage::disk('public')->put(
            $userAchievement->getCertificatePath(),
            $this->browsershot
                ->setHtml(
                    view($userAchievement->achievement->certificate_template_path, [
                        'achievement' => $userAchievement,
                        'user' => $userAchievement->user,
                    ])->render()
                )
                ->pdf()
        );
    }
}
