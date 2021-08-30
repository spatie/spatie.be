<?php

use App\Actions\SubscribeUserToNewsletterAction;
use App\Models\User;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

uses(TestCase::class);

it('subscribes the user to the spatie email list', function () {
    $action = resolve(SubscribeUserToNewsletterAction::class);
    $user = User::factory()->create();
    $emailList = EmailList::create([
        'name' => 'Spatie',
    ]);

    $this->assertSame(0, $emailList->subscribers()->count());

    $action->execute($user);

    $this->assertSame(1, $emailList->subscribers()->count());
    $this->assertSame($user->email, $emailList->subscribers->first()->email);
});
