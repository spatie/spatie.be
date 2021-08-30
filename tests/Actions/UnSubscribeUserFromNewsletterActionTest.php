<?php

use App\Actions\UnsubscribeUserFromNewsletterAction;
use App\Models\Subscriber;
use App\Models\User;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

uses(TestCase::class);

it('subscribes the user to the spatie email list', function () {
    $action = resolve(UnsubscribeUserFromNewsletterAction::class);
    $user = User::factory()->create();
    $emailList = EmailList::create([
        'name' => 'Spatie',
    ]);

    Subscriber::createWithEmail($user->email)
        ->skipConfirmation()
        ->subscribeTo($emailList);

    $this->assertSame(1, $emailList->subscribers()->count());

    $action->execute($user);

    $this->assertSame(0, $emailList->subscribers()->count());
});
