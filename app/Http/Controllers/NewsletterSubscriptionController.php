<?php

namespace App\Http\Controllers;

use App\Actions\SubscribeUserToNewsletterAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterSubscriptionController
{
    public function __invoke(Request $request, SubscribeUserToNewsletterAction $subscribeUserToNewsletter): RedirectResponse
    {
        $validator = Validator::make($request->only('email'), [
            'email' => ['required', 'email:strict,dns'],
        ]);

        if ($validator->fails()) {
            return redirect()->to(route('home', ['newsletter' => 'invalid-email']) . '#newsletter');
        }

        $subscribeUserToNewsletter->execute(email: $validator->validated()['email']);

        return redirect()->to(route('home', ['newsletter' => 'subscribed']) . '#newsletter');
    }
}
