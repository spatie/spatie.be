<?php

namespace App\Filament\Widgets\Purchases;

use App\Filament\Utils\ChartHelpers;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

abstract class BasePurchaseChartWidget extends ChartWidget
{
    public function toChartData(Collection $data, array $labels): array
    {
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
}
