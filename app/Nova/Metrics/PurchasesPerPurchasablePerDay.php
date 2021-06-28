<?php

namespace App\Nova\Metrics;

use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PurchasesPerPurchasablePerDay
{
    public static function create(): StackedChart
    {
        $purchases = DB::table('purchases')
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
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', now()->subMonth())
            ->groupByRaw("title, day")
            ->get();

        $colors = [
            '#F5573B',
            '#F99037',
            '#F2CB22',
            '#8FC15D',
            '#098F56',
            '#47C1BF',
            '#1693EB',
            '#6474D7',
            '#9C6ADE',
            '#E471DE',
            '#EC4899',
            '#8B5CF6',
            '#6366F1',
            '#3B82F6',
            '#10B981',
            '#F59E0B',
            '#EF4444',
        ];

        $purchasesByProduct = $purchases->sortBy('title')->groupBy('title');
        $days = $purchases->groupBy('day')->keys()->sort()->values();

        $data = $purchasesByProduct->map(function (Collection $purchasesOfProduct, $title) use ($colors, $purchasesByProduct, $days) {
            return [
                'label' => $title,
                'backgroundColor' => $colors[$purchasesByProduct->keys()->search($title)],
                'data' => $days->map(function (string $day) use ($purchasesOfProduct) {
                    return (int) ($purchasesOfProduct->where('day', $day)->first()?->count ?? 0);
                })->toArray(),
            ];
        })->values()->toArray();

        return (new StackedChart())
            ->title('Purchases per purchasable per day')
            ->animations([
                'enabled' => true,
                'easing' => 'easeinout',
            ])
            ->series($data)
            ->options([
                'layout' => [
                    'padding' => [
                        'left' => 15,
                        'right' => 15,
                        'top' => 15,
                        'bottom' => 15,
                    ],
                ],
                'legend' => [
                    'position' => 'bottom',
                ],
                'xaxis' => [
                    'categories' => $days->map(function (string $day) {
                        return Date::createFromFormat('Y-m-d', $day)->format('d/m');
                    })->values()->toArray(),
                ],
            ]);
    }
}
