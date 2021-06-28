<?php

namespace App\Nova\Metrics;

use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PurchasesPerProductPerMonth
{
    public static function create(): StackedChart
    {
        $purchases = DB::table('purchases')
            ->select([
                DB::raw("products.title as title"),
                DB::raw("date_format(purchases.created_at, '%Y-%m') as month"),
                DB::raw('sum(quantity) as count'),
            ])
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', now()->subYear())
            ->groupByRaw("title, month")
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
        $months = $purchases->groupBy('month')->keys()->sort()->values();

        $data = $purchasesByProduct->map(function (Collection $purchasesOfProduct, $title) use ($colors, $purchasesByProduct, $months) {
            return [
                'label' => $title,
                'backgroundColor' => $colors[$purchasesByProduct->keys()->search($title)],
                'data' => $months->map(function (string $month) use ($purchasesOfProduct) {
                    return (int) ($purchasesOfProduct->where('month', $month)->first()?->count ?? 0);
                })->toArray(),
            ];
        })->values()->toArray();

        return (new StackedChart())
            ->title('Purchases per product per month')
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
                    'categories' => $months->map(function (string $month) {
                        return Date::createFromFormat('Y-m', $month)->formatLocalized('%Y %b');
                    })->values()->toArray(),
                ],
            ]);
    }
}
