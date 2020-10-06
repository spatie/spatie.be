<?php

namespace App\Http\Controllers;

use App\Actions\HandlePurchaseAction;
use App\Support\Paddle\ProcessPaymentSucceededJob;
use Laravel\Paddle\Http\Controllers\WebhookController as CashierWebhookController;

class WebhookController extends CashierWebhookController
{
    private HandlePurchaseAction $handlePurchaseAction;

    public function __construct(HandlePurchaseAction $handlePurchaseAction)
    {
        parent::__construct();

        $this->handlePurchaseAction = $handlePurchaseAction;
    }

    public function handlePaymentSucceeded($payload): void
    {
        parent::handlePaymentSucceeded($payload);

        dispatch(new ProcessPaymentSucceededJob($payload));
    }
}
