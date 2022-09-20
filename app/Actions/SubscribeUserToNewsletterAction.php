<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class SubscribeUserToNewsletterAction
{
    public function execute(User $user): User
    {
        Http::withToken(config('services.mailcoach.token'))
            ->post('https://spatie.mailcoach.app/api/email-lists/4af46b59-3784-41a5-9272-6da31afa3a02/subscribers', [
                'email' => $user->email,
                'skip_confirmation' => true,
            ]);

        return $user;
    }
}
