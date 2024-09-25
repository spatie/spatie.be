<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Paddle\ProcessPaymentSucceededJob;
use Laravel\Paddle\Exceptions\InvalidPassthroughPayload;
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

    protected function findOrCreateCustomer(string $passthrough)
    {
        $passthrough = json_decode($passthrough, true);

        // The passthrough data comes from the shop front-end. We cannot trust it.
        if (! is_array($passthrough) || $passthrough['billable_type'] !== User::class) {
            throw new InvalidPassthroughPayload;
        }

        return parent::findOrCreateCustomer($passthrough);
    }
}
