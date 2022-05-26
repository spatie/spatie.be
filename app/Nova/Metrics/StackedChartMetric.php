<?php

namespace App\Nova\Metrics;

use Coroowicaksono\ChartJsIntegration\StackedChart;

abstract class StackedChartMetric
{
    abstract protected function getTitle(): string;

    abstract protected function getLabels(): array;

    abstract protected function getData(): array;

    public static function create(): StackedChart
    {
        $chart = new static();

        $colors = [
            '#be123c',
            '#be185d',
            '#a21caf',
            '#7e22ce',
            '#6d28d9',
            '#4338ca',
            '#1d4ed8',
            '#0369a1',
            '#0e7490',
            '#0f766e',
            '#047857',
            '#15803d',
            '#4d7c0f',
            '#a16207',
            '#b45309',
            '#c2410c',
            '#b91c1c',
            '#fb7185',
            '#f472b6',
            '#e879f9',
            '#c084fc',
            '#a78bfa',
            '#818cf8',
            '#60a5fa',
            '#38bdf8',
            '#22d3ee',
            '#2dd4bf',
            '#34d399',
            '#4ade80',
            '#a3e635',
            '#facc15',
            '#fbbf24',
            '#fb923c',
            '#f87171',
        ];

        $data = collect($chart->getData())->map(function (array $data, int $key) use ($colors) {
            $data['backgroundColor'] = $key >= count($colors)
                ? $colors[count($colors) - $key + 1]
                : $colors[$key];

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
