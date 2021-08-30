<?php

use App\Domain\Shop\Models\Purchase;
use App\Mail\PurchaseConfirmationMail;
use Tests\TestCase;

uses(TestCase::class);

test('the purchase confirmation mail can be rendered', function () {
    $purchase = Purchase::factory()->create();

    $mailable = new PurchaseConfirmationMail($purchase, $purchase->purchasable);

    $this->assertIsString($mailable->render());
});
