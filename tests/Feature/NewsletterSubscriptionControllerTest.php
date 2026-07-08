<?php

use App\Actions\SubscribeUserToNewsletterAction;

it('subscribes an email address to the newsletter', function () {
    $this->mock(SubscribeUserToNewsletterAction::class)
        ->shouldReceive('execute')
        ->once()
        ->withArgs(
            fn (?object $user = null, ?string $email = null) => $user === null && $email === 'hello@spatie.be'
        );

    $this
        ->post(route('newsletter.subscribe'), ['email' => 'hello@spatie.be'])
        ->assertRedirect(route('home', ['newsletter' => 'subscribed']) . '#newsletter');
});

it('redirects back to the homepage when the newsletter email is invalid', function () {
    $this->mock(SubscribeUserToNewsletterAction::class)
        ->shouldNotReceive('execute');

    $this
        ->post(route('newsletter.subscribe'), ['email' => 'not-an-email'])
        ->assertRedirect(route('home', ['newsletter' => 'invalid-email']) . '#newsletter');
});
