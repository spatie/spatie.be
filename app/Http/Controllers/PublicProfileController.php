<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class PublicProfileController
{
    public function show(string $userUuid)
    {
        $user = User::query()->where('uuid', $userUuid)->firstOrFail();

        return view('front.profile.publicProfile', ['user' => $user]);
    }

    public function achievement(string $userUuid, string $slug)
    {
        $user = User::query()->where('uuid', $userUuid)->firstOrFail();

        $achievement = $user->achievements()->where('slug', $slug)->firstOrFail();

        return view('front.profile.publicAchievement', [
            'user' => $user,
            'achievement' => $achievement,
        ]);
    }

    public function ogImage(string $userUuid, string $slug)
    {
        $user = User::query()->where('uuid', $userUuid)->firstOrFail();

        $userAchievement = $user->achievements()->where('slug', $slug)->firstOrFail();

        return view('front.profile.achievementOgImage', [
            'achievement' => $userAchievement,
            'user' => $userAchievement->user,
        ]);
    }

    public function certificate(Browsershot $browsershot, string $userUuid, string $slug)
    {
        $user = User::query()->where('uuid', $userUuid)->firstOrFail();

        /** @var \App\Domain\Experience\Projections\UserAchievementProjection $userAchievement */
        $userAchievement = $user->achievements()->where('slug', $slug)->firstOrFail();

        Storage::disk('public')->put(
            $userAchievement->getCertificatePath(),
            $browsershot
                ->setHtml(
                    view($userAchievement->achievement->certificate_template_path, [
                        'achievement' => $userAchievement,
                        'user' => $userAchievement->user,
                    ])->render()
                )
                ->pdf()
        );

        return response()->file(Storage::disk('public')->path($userAchievement->getCertificatePath()));
    }
}
