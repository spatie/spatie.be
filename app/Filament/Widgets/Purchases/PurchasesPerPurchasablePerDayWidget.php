<?php

namespace App\Filament\Widgets\Purchases;

use Illuminate\Support\Facades\DB;

class PurchasesPerPurchasablePerDayWidget extends BasePurchaseChartWidget
{
    protected static ?string $heading = 'Purchases per Purchasable';

    protected string|int|array $columnSpan = 3;

    protected function getData(): array
    {
        $startDate = $this->getStartDate();
        $labels = $this->getLabels($startDate);
        $intervalFormat = $this->filter === 'month' ? '%Y-%m' : '%Y-%m-%d';

        $data = DB::table('purchases')
            ->select([
                DB::raw("
                    CASE
                        WHEN products.title = purchasables.title THEN purchasables.title
                        ELSE CONCAT(products.title, ': ', purchasables.title)
                    END as title
                "),
                DB::raw("date_format(purchases.created_at, '$intervalFormat') as day"),
                DB::raw('sum(quantity) as count'),
            ])
            ->where('earnings', '>', '0')
            ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
            ->join('products', 'products.id', '=', 'purchasables.product_id')
            ->where('purchases.created_at', '>=', now()->subMonth())
            ->groupByRaw("title, day")
            ->get();

        return $this->toChartData($data, $labels);
    }
}
