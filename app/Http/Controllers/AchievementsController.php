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
}
