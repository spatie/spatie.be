<?php

namespace App\Http\Controllers;

use App\Actions\RestoreRepositoryAccessAction;
use App\Models\User;
use App\Services\GitHub\GitHubGraphApi;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GitHubSocialiteController
{
    public function redirect()
    {
        session()->reflash();

        if (auth()->check()) {
            /*
             * If somebody is already logged in, the user wants to
             * connect their GitHub profile. Remember who's logged in.
             */
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

        /*
         * Make sure the user has access to all repositories that
         * belong to past purchases.
         */
        app(RestoreRepositoryAccessAction::class)->execute($user);

        if (! $user->is_sponsor && ! $user->isSpatieMember()) {
            /*
             * Display a flash warning on the profile page that the user
             * is not yet a sponsor
             */
            session()->flash('not-a-sponsor');
        }

        auth()->login($user, true);

        flash()->success('You have been logged in');

        return redirect()->to(session('next', route('products.index')));
    }

    protected function retrieveUser($gitHubUser): User
    {
        if (session('auth-user-email')) {
            /*
             * If there already was a local user created for the email used
             * on GitHub, then let's use that local user
             */
            return User::where('email', session('auth-user-email'))->first();
        }

        if ($user = User::where('github_id', $gitHubUser->id)->orWhere('email', $gitHubUser->email)->first()) {
            /*
             * Somebody tries to login via GitHub that already
             * has been logged in, in the past.
             */
            return $user;
        }

        /*
         * Somebody tries to login via GitHub that doesn't have a local user
         * yet. Let's create a new local user.
         */
        return User::create([
            'password' => bcrypt(Str::random()),
            'email' => $gitHubUser->email,
            'name' => $gitHubUser->name ?? $gitHubUser->nickname,
        ]);
    }
}
