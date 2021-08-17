<?php

namespace App\Mail;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Purchase $purchase,
        public Purchasable $purchasable,
    ) {
    }

    public function build()
    {
        return $this
            ->subject("Getting started with {$this->purchasable->product->title}")
            ->to($this->purchase->user->email)
            ->markdown('mails.purchaseConfirmation');
    }
}
