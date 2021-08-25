<?php

namespace App\Http\Controllers;

use App\Support\Paddle\ProcessPaymentSucceededJob;
use Laravel\Paddle\Http\Controllers\WebhookController as CashierWebhookController;

class WebhookController extends CashierWebhookController
{
    public function handlePaymentSucceeded($payload): void
    {
        // Temporary to stop Paddle sending a broken webhook
        if ($payload['alert_id'] == '67411838') {
            return;
        }

        parent::handlePaymentSucceeded($payload);

        dispatch(new ProcessPaymentSucceededJob($payload));
    }
}
