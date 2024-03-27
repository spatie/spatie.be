<?php

namespace App\Filament\Widgets;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Utils\ChartHelpers;
use App\Filament\Widgets\Purchases\BasePurchaseChartWidget;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PurchasesPerPurchasablePerDayWidget extends BasePurchaseChartWidget
{
    protected static ?string $heading = 'Purchases per Purchasable';

    protected string|int|array $columnSpan = 3;

    protected function getData(): array
    {
        $startDate = now()->subMonth()->startOfDay();
        $endDate = now()->endOfDay();
        $period = CarbonPeriod::create($startDate, $endDate);

        $labels = collect($period->toArray())->map(function ($date) {
            return $date->format('Y-m-d');
        })->toArray();

        $data = DB::table('purchases')
            ->select([
                DB::raw("
                    CASE
                        WHEN products.title = purchasables.title THEN purchasables.title
                        ELSE CONCAT(products.title, ': ', purchasables.title)
                    END as title
                "),
                DB::raw("date_format(purchases.created_at, '%Y-%m-%d') as day"),
                DB::raw('sum(quantity) as count'),
            ])
            ->where('earnings', '>', '0')
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', now()->subMonth())
            ->groupByRaw("title, day")
            ->get();

        return $this->toChartData($data, $labels);
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
        return [];
    }

    protected static ?array $options = [
        'scales' => [
            'x' => [
                'stacked' => true,
            ],
            'y' => [
                'stacked' => true,
            ],
        ],
    ];
}
