<?php

namespace App\Http\Controllers;

use App\Support\Paddle\ProcessPaymentSucceededJob;
use Laravel\Paddle\Http\Controllers\WebhookController as CashierWebhookController;

class WebhookController extends CashierWebhookController
{
    public function handlePaymentSucceeded($payload): void
    {
        parent::handlePaymentSucceeded($payload);

        dispatch(new ProcessPaymentSucceededJob($payload));
    }
}
