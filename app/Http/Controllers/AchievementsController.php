<?php

namespace App\Http\Controllers;

class AchievementsController
{
    public function show()
    {
        return view('front.profile.achievements', [
            'user' => current_user(),
        ]);
    }

    public function certificateDownload(string $slug)
    {
        $user = current_user();

        $userAchievement = $user->achievements()->where('slug', $slug)->firstOrFail();

        return view('front.profile.achievementCertificate', [
            'achievement' => $userAchievement,
        ]);
    }
}
