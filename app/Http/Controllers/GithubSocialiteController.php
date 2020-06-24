<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GitHub\GitHubGraphApi;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubSocialiteController
{
    public function redirect()
    {
        session()->put('before-github-redirect', url()->previous());
        if (auth()->check()) {
            session()->put('auth-user-email', auth()->user()->email);
        }

        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $gitHubUser = Socialite::driver('github')->stateless()->user();

        $isSponsor = (new GitHubGraphApi())->isSponsor($gitHubUser->nickname);

        if (session('auth-user-email')) {
            $user = User::where('email', session('auth-user-email'))->first();
        } else {
            $user = User::firstOrCreate([
                'github_id' => $gitHubUser->id,
            ], [
                'password' => bcrypt(Str::random()),
                'email' => $gitHubUser->email,
                'name' => $gitHubUser->name ?? $gitHubUser->nickname,
            ]);
        }

        $user->update([
            'github_id' => $gitHubUser->id,
            'github_username' => $gitHubUser->nickname,
            'avatar' => $gitHubUser->avatar,
            'is_sponsor' => $isSponsor,
        ]);

        ($user->is_sponsor || $user->isSpatieMember())
            ? auth()->login($user)
            : session()->flash('not-a-sponsor');

        return redirect()->to(session('before-github-redirect', route('videos.index')));
    }
}
