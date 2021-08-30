<?php

use App\Actions\SubscribeUserToNewsletterAction;
use App\Models\User;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;



it('subscribes the user to the spatie email list', function () {
    $action = resolve(SubscribeUserToNewsletterAction::class);
    $user = User::factory()->create();
    $emailList = EmailList::create([
        'name' => 'Spatie',
    ]);

    expect($emailList->subscribers()->count())->toBe(0);

    $action->execute($user);

    expect($emailList->subscribers()->count())->toBe(1);
    expect($emailList->subscribers->first()->email)->toBe($user->email);
});
