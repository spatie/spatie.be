<?php

namespace App\Http\Controllers;

use App\Models\User;

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

    public function meta(string $userUuid, string $slug)
    {
        $user = User::query()->where('uuid', $userUuid)->firstOrFail();

        $achievement = $user->achievements()->where('slug', $slug)->firstOrFail();

        return view('front.profile.achievementOgImage', [
            'achievement' => $achievement,
            'user' => $achievement->user,
        ]);
    }
}
