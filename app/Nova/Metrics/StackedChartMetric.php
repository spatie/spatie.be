<?php

namespace App\Nova\Metrics;

use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

abstract class StackedChartMetric
{
    protected abstract function getTitle(): string;
    protected abstract function getLabels(): array;
    protected abstract function getData(): array;

    public static function create(): StackedChart
    {
        $chart = new static();

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

        $data = collect($chart->getData())->map(function (array $data, int $key) use ($colors) {
            $data['backgroundColor'] = $colors[$key];
            return $data;
        })->toArray();

        return (new StackedChart())
            ->title($chart->getTitle())
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
                    'categories' => $chart->getLabels(),
                ],
            ]);
    }
}
