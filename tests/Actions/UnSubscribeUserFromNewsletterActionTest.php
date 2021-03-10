<?php

namespace Tests\Actions;

use App\Actions\UnsubscribeUserFromNewsletterAction;
use App\Models\Subscriber;
use App\Models\User;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

class UnSubscribeUserFromNewsletterActionTest extends TestCase
{
    /** @test * */
    public function it_subscribes_the_user_to_the_spatie_email_list()
    {
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
    }
}
