<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PurchasesPerPurchasablePerMonth extends StackedChartMetric
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
                DB::raw("date_format(purchases.created_at, '%Y-%m') as month"),
                DB::raw('sum(quantity) as count'),
            ])
            ->where('earnings', '>', '0')
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', now()->subYear())
            ->groupByRaw("title, month")
            ->get();
    }

    protected function getTitle(): string
    {
        return 'Purchases per purchasable per month';
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
                    return (int) ($purchasesOfProduct->where('month', $month)->first()?->count ?? 0);
                })->toArray(),
            ];
        })->values()->toArray();
    }
}
