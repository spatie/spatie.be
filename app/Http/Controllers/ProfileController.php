<?php

namespace App\Http\Controllers;

use App\Http\Auth\Requests\ProfileRequest;

class ProfileController
{
    public function show()
    {
        return view('front.profile.profile');
    }

    public function update(ProfileRequest $profileRequest)
    {
        auth()->user()->update($profileRequest->except('newsletter'));

        if ($profileRequest->get('newsletter')) {
            // @todo: Check if user was subscribed and needs to be unsubscribed or vise versa
        }

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
