<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Services\GitHub\GitHubApi;
use App\Services\GitHub\GitHubGraphApi;
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

        $isSponsor = GitHubGraphApi::isSponsor($gitHubUser->nickname);

        if (! $isSponsor) {
            return redirect()->to(session('before-github-redirect', route('videos.index')));
        }

        $user = User::updateOrCreate([
            'github_id' => $gitHubUser->id,
        ], [
            'github_username' => $gitHubUser->nickname,
            'email' => $gitHubUser->email,
            'name' => $gitHubUser->name,
            'avatar' => $gitHubUser->avatar,
            'password' => Str::random(),
            'is_sponsor' => $isSponsor,
        ]);

        auth()->login($user);

        return redirect()->to(session('before-github-redirect', route('videos.index')));
    }
}
