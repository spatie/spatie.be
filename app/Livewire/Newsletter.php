<?php

namespace App\Livewire;

use App\Actions\SubscribeUserToNewsletterAction;
use Livewire\Component;

class Newsletter extends Component
{
    public string $email = '';

    public bool $submitted = false;

    public function subscribe(): void
    {
        $this->validate([
            'email' => 'required|email:strict,dns',
        ]);

        app(SubscribeUserToNewsletterAction::class)
            ->execute(email: $this->email);

        $this->submitted = true;
    }
}
