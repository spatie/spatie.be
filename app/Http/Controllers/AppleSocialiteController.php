<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;

class AppleSocialiteController
{
    public function redirect()
    {
        session()->reflash();

        if (auth()->check()) {
            /*
             * If somebody is already logged in, the user wants to
             * connect their Apple account. Remember who's logged in.
             */
            session()->put('auth-user-id', auth()->user()->id);
        }

        return Socialite::driver('apple')->redirect();
    }

    public function callback()
    {
        session()->replace(json_decode(request('state'), true));

        $appleUser = Socialite::driver('apple')->user();

        $user = $this->retrieveUser($appleUser);

        $user->update([
            'apple_id' => $appleUser->getId(),
        ]);

        auth()->login($user, true);

        flash()->success('You have been logged in');

        return view('auth.appleCallback');
    }

    protected function retrieveUser(SocialiteUser $appleUser): User
    {
        if (session('auth-user-id')) {
            /*
             * If there already was a local user created for the email used
             * on Apple, then let's use that local user
             */
            return User::find(session('auth-user-id'));
        }

        /*
         * Somebody tries to login via Apple that already
         * has an account with this email.
         * We'll link this Apple profile to this account.
         */
        if ($appleUser->getEmail() && $user = User::where('email', $appleUser->getEmail())->first()) {
            return $user;
        }

        return User::firstOrCreate([
            'apple_id' => $appleUser->getId(),
        ], [
            'password' => bcrypt(Str::random()),
            'email' => $appleUser->getEmail(),
            'name' => $appleUser->getName() ?? $appleUser->getNickname() ?? $appleUser->getEmail(),
        ]);
    }
}
