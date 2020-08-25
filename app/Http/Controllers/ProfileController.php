<?php

namespace App\Http\Controllers;

use App\Actions\SubscribeUserToNewsletterAction;
use App\Actions\UnsubscribeUserFromNewsletterAction;
use App\Http\Auth\Requests\ProfileRequest;

class ProfileController
{
    public function show()
    {
        return view('front.profile.profile');
    }

    public function update(ProfileRequest $profileRequest)
    {
        /** @var \App\Models\User $user */
        $user = $profileRequest->user();

        $profileRequest->get('newsletter')
            ? app(SubscribeUserToNewsletterAction::class)->execute($user)
            : app(UnsubscribeUserFromNewsletterAction::class)->execute($user);

        $user->update($profileRequest->except('newsletter'));

        flash()->success('Profile updated successfully.');

        return redirect()->route('profile');
    }

    public function disconnect()
    {
        auth()->user()->update([
            'github_id' => null,
            'github_username' => null,
        ]);

        flash()->success('Github account disconnected.');

        return redirect()->route('profile');
    }

    public function delete()
    {
        auth()->user()->delete();
        auth()->logout();

        flash()->success('Account deleted.');

        return redirect()->route('home');
    }
}
