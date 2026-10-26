<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Actions\RestoreRepositoryAccessAction;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

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
            session()->put('auth-user-id', auth()->user()->id);
            session()->flash('next', route('purchases'));
        }

        return Socialite::driver('github')->redirect();
    }

    public function callback(): View
    {
        $gitHubUser = Socialite::driver('github')->stateless()->user();

        $user = $this->retrieveUser($gitHubUser);
        // $isSponsor = (new GitHubGraphApi())->determineSponsorStatus($gitHubUser->nickname) ?? $user->is_sponsor;

        $user->update([
            'github_id' => $gitHubUser->id,
            'github_username' => $gitHubUser->nickname,
            'avatar' => $gitHubUser->avatar,
            // 'is_sponsor' => $isSponsor,
        ]);

        flash()->success('You have been logged in');

        try {
            /*
             * Make sure the user has access to all repositories that
             * belong to past purchases.
             */
            app(RestoreRepositoryAccessAction::class)->execute($user);
        } catch (Throwable $exception) {
            report("Could not restore repository access for user `{$user->id}` after GitHub login: {$exception->getMessage()}");
            flash()->error('Your GitHub account is connected, but repository access could not be restored. Please try again or contact support.');
        }

        if (! $user->is_sponsor && ! $user->isSpatieMember()) {
            /*
             * Display a flash warning on the profile page that the user
             * is not yet a sponsor
             */
            session()->flash('not-a-sponsor');
        }

        auth()->login($user, true);

        return view('auth.gitHubCallback', [
            'redirectUrl' => session()->pull('next', route('products.index')),
        ]);
    }

    protected function retrieveUser($gitHubUser): User
    {
        if ($userId = session()->pull('auth-user-id')) {
            /*
             * If there already was a local user created for the email used
             * on GitHub, then let's use that local user
             */
            return User::findOrFail($userId);
        }

        if ($gitHubUser->email && $user = User::where('email', $gitHubUser->email)->first()) {
            /*
             * Somebody tries to login via GitHub that already
             * has an account with this email.
             * We'll link this GitHub profile to this account.
             */
            return $user;
        }

        return User::firstOrCreate([
            'github_id' => $gitHubUser->id,
        ], [
            'password' => bcrypt(Str::random()),
            'email' => $gitHubUser->email,
            'name' => $gitHubUser->name ?? $gitHubUser->nickname,
        ]);
    }
}
