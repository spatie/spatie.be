<?php

use App\Actions\UnsubscribeUserFromNewsletterAction;
use App\Models\Subscriber;
use App\Models\User;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

it('subscribes the user to the spatie email list', function () {
    $action = resolve(UnsubscribeUserFromNewsletterAction::class);
    $user = User::factory()->create();
    $emailList = EmailList::create([
        'name' => 'Spatie',
    ]);

    Subscriber::createWithEmail($user->email)
        ->skipConfirmation()
        ->subscribeTo($emailList);

    expect($emailList->subscribers()->count())->toBe(1);

    $action->execute($user);

    expect($emailList->subscribers()->count())->toBe(0);
});
