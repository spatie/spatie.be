<?php

namespace App\Filament\Widgets;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Utils\ChartHelpers;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsWidget extends ChartWidget
{
    protected static ?string $heading = 'Payment Methods';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $startDate = match ($this->filter) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'year' => now()->subYear(),
            default => now()->subYear(30),
        };

        $results = Purchase::query()
            ->whereHas('receipt', function (Builder $query): void {
                $query->where('amount', '!=', 0);
            })
            ->select([DB::raw('COUNT(*) as count'), DB::raw("JSON_UNQUOTE(JSON_EXTRACT(paddle_webhook_payload, '$.payment_method')) as payment_method")])
            ->where('purchases.created_at', '>=', $startDate)
            ->groupBy('payment_method')
            ->orderByDesc('count')
            ->get();

        $data = $results->map(function ($result) {
            $label = match ($result->payment_method) {
                'card' => 'Credit card',
                'apple-pay' => 'Apple Pay',
                'paypal' => 'PayPal',
                'google-pay' => 'Google Pay',
                'ideal' => 'iDeal',
                null => 'Undefined',
                default => $result->payment_method,
            };

            return [
                'label' => $label,
                'count' => $result->count,
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Purchases Per Product',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => ChartHelpers::chartColors(),
                ],
            ],
            'labels' => $data->pluck('label')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Time',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
