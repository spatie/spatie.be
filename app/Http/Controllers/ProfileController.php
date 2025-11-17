<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Actions\SubscribeUserToNewsletterAction;
use App\Actions\UnsubscribeUserFromNewsletterAction;
use App\Http\Auth\Requests\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController
{
    public function show(): View
    {
        return view('front.profile.profile');
    }

    public function update(ProfileRequest $profileRequest): RedirectResponse
    {
        /** @var User $user */
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

    public function disconnect(): RedirectResponse
    {
        auth()->user()->update([
            'github_id' => null,
            'github_username' => null,
        ]);

        flash()->success('Github account disconnected.');

        return redirect()->route('profile');
    }

    public function delete(): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->purchases()->delete();
        $user->licenses()->delete();
        $user->receipts()->delete();
        $user->completedLessons()->sync([]);
        $user->delete();

        auth()->logout();

        flash()->success('Account deleted.');

        return redirect()->route('home');
    }
}
