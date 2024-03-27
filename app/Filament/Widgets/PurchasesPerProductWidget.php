<?php

namespace App\Filament\Widgets;

use App\Domain\Shop\Models\Purchase;
use App\Filament\Utils\ChartHelpers;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PurchasesPerProductWidget extends ChartWidget
{
    protected static ?string $heading = 'Purchases per Product';

    protected function getData(): array
    {
        $data = Purchase::query()
            ->whereHas('receipt', function (Builder $query): void {
                $query->where('amount', '!=', 0);
            })
            ->select('purchasables.product_id', 'products.title', DB::raw('count(*) as aggregate'))
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->groupBy('product_id')
            ->get();

        return [
//            'datasets' => $data->map(function ($item) {
//                return [
//                    'label' => $item->title,
//                    'data' => [$item->aggregate],
//                ];
//            })->toArray(),
            'datasets' => [
                [
                    'label' => 'Purchases Per Product',
                    'data' => $data->pluck('aggregate')->toArray(),
                    'backgroundColor' => ChartHelpers::chartColors(),
                ],
            ],
            'labels' => $data->pluck('title')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getFilters(): ?array
    {
        return [];
    }
}
