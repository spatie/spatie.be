<?php

namespace App\Http\Controllers;

use App\Models\Screencast;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubSocialiteController extends Controller
{
    public function redirect()
    {
        session()->put('before-github-redirect', url()->previous());

        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $gitHubUser = Socialite::driver('github')->stateless()->user();

        $user = User::updateOrCreate([
            'github_id' => $gitHubUser->id,
        ], [
            'github_username' => $gitHubUser->nickname,
            'email' => $gitHubUser->email,
            'name' => $gitHubUser->name,
            'avatar' => $gitHubUser->avatar,
            'password' => Str::random(),
        ]);

        auth()->login($user);

        return redirect()->to(session('before-github-redirect', Screencast::orderBy('sort')->first()->url));
    }
}
