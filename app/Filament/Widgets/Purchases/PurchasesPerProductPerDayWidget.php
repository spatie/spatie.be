<?php

namespace App\Filament\Widgets\Purchases;

use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class PurchasesPerProductPerDayWidget extends BasePurchaseChartWidget
{
    protected static ?string $heading = 'Purchases per Product';

    protected string|int|array $columnSpan = 3;

    protected function getData(): array
    {
        $startDate = $this->getStartDate();
        $labels = $this->getLabels($startDate);
        $intervalFormat = $this->filter === 'month' ? '%Y-%m' : '%Y-%m-%d';

        $data = DB::table('purchases')
            ->select([
                DB::raw("products.title as title"),
                DB::raw("date_format(purchases.created_at, '$intervalFormat') as day"),
                DB::raw('sum(quantity) as count'),
            ])
            ->where('earnings', '>', '0')
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', $startDate)
            ->groupByRaw("title, day")
            ->get();

        return $this->toChartData($data, $labels);
    }
}
