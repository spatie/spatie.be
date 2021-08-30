<?php

use App\Domain\Shop\Models\Purchase;
use App\Mail\PurchaseConfirmationMail;
use Tests\TestCase;



test('the purchase confirmation mail can be rendered', function () {
    $purchase = Purchase::factory()->create();

    $mailable = new PurchaseConfirmationMail($purchase, $purchase->purchasable);

    expect($mailable->render())->toBeString();
});
