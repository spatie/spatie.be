<?php

namespace Tests\Actions;

use App\Actions\SubscribeUserToNewsletterAction;
use App\Models\User;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

class SubscribeUserToNewsletterActionTest extends TestCase
{
    /** @test * */
    public function it_subscribes_the_user_to_the_spatie_email_list()
    {
        $action = resolve(SubscribeUserToNewsletterAction::class);
        $user = User::factory()->create();
        $emailList = EmailList::create([
            'name' => 'Spatie',
        ]);

        $this->assertSame(0, $emailList->subscribers()->count());

        $action->execute($user);

        $this->assertSame(1, $emailList->subscribers()->count());
        $this->assertSame($user->email, $emailList->subscribers->first()->email);
    }
}
