<?php

namespace App\Livewire;

use App\Actions\SubscribeUserToNewsletterAction;
use App\Services\Mailcoach\MailcoachApi;
use Livewire\Component;

class NewsletterComponent extends Component
{
    public string $email = '';

    public bool $submitted = false;

    public function render()
    {
        return view('livewire.newsletter-component');
    }

    public function subscribe()
    {
        //TODO: make this work
        $this->validate([
            'email' => 'required|email',
        ]);

        $mailcoach = app(MailcoachApi::class);

        $subscriber = $mailcoach->subscribe(strtolower($this->email), skipConfirmation: true);
        $subscriber->addTags('spatie-newsletter');

        $this->submitted = true;
    }
}
