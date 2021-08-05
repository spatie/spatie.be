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
}
