<?php

namespace Tests\Unit\Mails;

use App\Mail\PurchaseConfirmationMail;
use App\Models\Purchase;
use Tests\TestCase;

class PurchaseConfirmationMailTest extends TestCase
{
    /** @test */
    public function the_PurchaseConfirmationMail_can_be_rendered()
    {
        $purchase = Purchase::factory()->create();

        $mailable = new PurchaseConfirmationMail($purchase, $purchase->purchasable);

        $this->assertIsString($mailable->render());
    }
}
