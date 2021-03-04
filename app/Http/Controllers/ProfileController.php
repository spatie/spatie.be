<?php

namespace App\Http\Controllers;

use App\Actions\SubscribeUserToNewsletterAction;
use App\Actions\UnsubscribeUserFromNewsletterAction;
use App\Http\Auth\Requests\ProfileRequest;

class ProfileController
{
    public function show()
    {
        ray()->showQueries();

        return view('front.profile.profile');
    }

    public function update(ProfileRequest $profileRequest)
    {

        /** @var \App\Models\User $user */
        $user = $profileRequest->user();

        if ($user->email) {
            $profileRequest->get('newsletter')
                ? app(SubscribeUserToNewsletterAction::class)->execute($user)
                : app(UnsubscribeUserFromNewsletterAction::class)->execute($user);
        }

        $user->update($profileRequest->getUserAttributes());

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

    public function disconnectApple()
    {
        auth()->user()->update([
            'apple_id' => null,
        ]);

        flash()->success('Apple account disconnected.');

        return redirect()->route('profile');
    }

    public function delete()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $user->purchases()->delete();
        $user->licenses()->delete();
        $user->receipts()->delete();
        $user->completedVideos()->sync([]);
        $user->delete();

        auth()->logout();

        flash()->success('Account deleted.');

        return redirect()->route('home');
    }
}
