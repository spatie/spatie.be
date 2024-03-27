<?php

namespace App\Filament\Widgets;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Utils\ChartHelpers;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PurchasesPerProductPerDayWidget extends ChartWidget
{
    protected static ?string $heading = 'Purchases per Product';

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
                DB::raw("products.title as title"),
                DB::raw("date_format(purchases.created_at, '%Y-%m-%d') as day"),
                DB::raw('sum(quantity) as count'),
            ])
            ->where('earnings', '>', '0')
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', $startDate)
            ->groupByRaw("title, day")
            ->get();

        $data = $data->groupBy('title');

        $chartData = [];
        $i = 0;
        foreach ($data as $title => $product) {
            $productData = [
                'label' => $title,
                'data' => [],
                'backgroundColor' => ChartHelpers::chartColor($i),
            ];

            foreach ($labels as $label) {
                $productData['data'][$label] = 0;
            }

            foreach ($product as $item) {
                $productData['data'][$item->day] = $item->count;
            }

            $productData['data'] = array_values($productData['data']);

            $chartData[] = $productData;
            $i++;
        }

        return [
            'datasets' => $chartData,
            'labels' => $labels,
        ];
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
