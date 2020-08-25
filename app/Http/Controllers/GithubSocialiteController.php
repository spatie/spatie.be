<?php

namespace App\Http\Controllers;

use App\Actions\RestoreRepositoryAccessAction;
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

        $user = $this->retrieveUser($gitHubUser);

        $user->update([
            'github_id' => $gitHubUser->id,
            'github_username' => $gitHubUser->nickname,
            'avatar' => $gitHubUser->avatar,
            'is_sponsor' => $isSponsor,
        ]);

        app(RestoreRepositoryAccessAction::class)->execute($user);

        if (! $user->is_sponsor && ! $user->isSpatieMember()) {
            session()->flash('not-a-sponsor');
        }

        auth()->login($user);

        flash()->success('You have been logged in');

        return redirect()->to(session('before-github-redirect', route('products.index')));
    }

    protected function retrieveUser($gitHubUser): User
    {
        if (session('auth-user-email')) {
            return User::where('email', session('auth-user-email'))->first();
        }

        if ($user = User::where('github_id', $gitHubUser->id)->orWhere('email', $gitHubUser->email)->first()) {
            return $user;
        }

        return User::create([
            'password' => bcrypt(Str::random()),
            'email' => $gitHubUser->email,
            'name' => $gitHubUser->name ?? $gitHubUser->nickname,
        ]);
    }
}
