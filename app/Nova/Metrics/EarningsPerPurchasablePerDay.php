<?php

namespace App\Nova\Metrics;

use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EarningsPerPurchasablePerDay extends StackedChartMetric
{
    private Collection $data;

    public function __construct()
    {
        $this->data = DB::table('purchases')
            ->select([
                DB::raw("
                    CASE
                        WHEN products.title = purchasables.title THEN purchasables.title
                        ELSE CONCAT(products.title, ': ', purchasables.title)
                    END as title
                "),
                DB::raw("date_format(purchases.created_at, '%Y-%m-%d') as day"),
                DB::raw('sum(earnings) as earnings'),
            ])
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', now()->subMonth())
            ->groupByRaw("title, day")
            ->get();
    }

    protected function getTitle(): string
    {
        return 'Earnings per purchasable per day';
    }

    protected function getLabels(): array
    {
        return $this->data->groupBy('day')->keys()->sort()->values()->toArray();
    }

    protected function getData(): array
    {
        return $this->data->groupBy('title')->map(function (Collection $purchasesOfProduct, $title) {
            return [
                'label' => $title,
                'data' => collect($this->getLabels())->map(function (string $day) use ($purchasesOfProduct) {
                    return round($purchasesOfProduct->where('day', $day)->first()?->earnings ?? 0, 2);
                })->toArray(),
            ];
        })->values()->toArray();
    }
}
