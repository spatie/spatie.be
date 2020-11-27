<?php

namespace Tests\Unit\Mails;

use App\Mail\NextPurchaseDiscountPeriodStartedMail;
use App\Models\User;
use Tests\TestCase;

class NextPurchaseDiscountPeriodStartedMailTest extends TestCase
{
    /** @test */
    public function the_NextPurchaseDiscountPeriodStartedMail_can_be_rendered()
    {
        $user = User::factory()->create();

        $mailable = new NextPurchaseDiscountPeriodStartedMail($user);

        $this->assertIsString($mailable->render());
    }
}
