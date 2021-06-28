<?php

namespace App\Nova\Metrics;

use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EarningsPerProductPerMonth extends StackedChartMetric
{
    private Collection $data;

    public function __construct()
    {
        $this->data = DB::table('purchases')
            ->select([
                DB::raw("products.title as title"),
                DB::raw("date_format(purchases.created_at, '%Y-%m') as month"),
                DB::raw('sum(earnings) as earnings'),
            ])
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', now()->subYear())
            ->groupByRaw("title, month")
            ->get();
    }

    protected function getTitle(): string
    {
        return 'Earnings per product per month';
    }

    protected function getLabels(): array
    {
        return $this->data->groupBy('month')->keys()->sort()->values()->toArray();
    }

    protected function getData(): array
    {
        return $this->data->groupBy('title')->map(function (Collection $purchasesOfProduct, $title) {
            return [
                'label' => $title,
                'data' => collect($this->getLabels())->map(function (string $month) use ($purchasesOfProduct) {
                    return round($purchasesOfProduct->where('month', $month)->first()?->earnings ?? 0, 2);
                })->toArray(),
            ];
        })->values()->toArray();
    }
}
