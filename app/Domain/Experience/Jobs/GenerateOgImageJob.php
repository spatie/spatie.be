<?php

namespace App\Domain\Experience\Jobs;

use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\User;
use App\Support\Browsershot\Browsershot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateOgImageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public User $user,
        public UserAchievementProjection $userAchievement,
        public string $path
    ) {
    }

    public function handle(Browsershot $browsershot)
    {
        Storage::disk('public')->put(
            $this->path,
            $browsershot
                ->setHtml(
                    view('front.profile.achievementOgImage', [
                        'achievement' => $this->userAchievement,
                        'user' => $this->user,
                    ])->render()
                )
                ->devicePixelRatio(2)
                ->windowSize(1200, 630)
                ->screenshot()
        );
    }
}
