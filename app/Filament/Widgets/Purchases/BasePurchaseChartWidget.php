<?php

namespace App\Filament\Widgets\Purchases;

use App\Filament\Utils\ChartHelpers;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

    public function getLabels($startDate): array
    {
        $period = CarbonPeriod::create($startDate, now());

        return collect($period->toArray())->map(function ($date) {
            return $date->format($this->filter === 'month' ? 'Y-m' : 'Y-m-d');
        })->unique()->values()->toArray();
    }

    public function getStartDate(): Carbon
    {
        return match ($this->filter) {
            'month' => now()->subYear()->startOfDay(),
            default => now()->subMonth()->startOfDay(),
        };
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
        return [
            'day' => 'Per Day',
            'month' => 'Per Month',
        ];
    }

    protected ?array $options = [
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
