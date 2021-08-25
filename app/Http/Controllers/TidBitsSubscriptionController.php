<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TidBitsSubscriptionController
{
    public function __invoke(string $email)
    {
        Http::post('https://spatie.be/mailcoach/subscribe/4af46b59-3784-41a5-9272-6da31afa3a02', [
            'tags' => 'testing-tidbits',
            'email' => $email,
        ]);

        return redirect()->to('https://testing-laravel.com/?tidbits=1');
    }
}
