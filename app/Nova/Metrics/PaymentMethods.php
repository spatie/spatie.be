<?php

namespace App\Nova\Metrics;

use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class PaymentMethods extends Partition
{
    public $name = 'Payment Methods';

    public function calculate(NovaRequest $request)
    {
        $results = Purchase::query()
            ->whereHas('receipt', function (Builder $query): void {
                $query->where('amount', '!=', 0);
            })
            ->select([DB::raw('COUNT(*) as count'), DB::raw("JSON_UNQUOTE(JSON_EXTRACT(paddle_webhook_payload, '$.payment_method')) as payment_method")])
            ->groupBy('payment_method')
            ->orderByDesc('count')
            ->get();

        return $this->result($results->mapWithKeys(function ($result) {
            $label = match($result->payment_method) {
                'card' => 'Credit card',
                'apple-pay' => 'Apple Pay',
                'paypal' => 'PayPal',
                'google-pay' => 'Google Pay',
                'ideal' => 'iDeal',
                null => 'Undefined',
                default => $result->payment_method,
            };

            return [$label => $result->count];
        })->toArray());
    }

    public function uriKey()
    {
        return 'payment-methods';
    }
}
