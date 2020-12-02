<?php

namespace App\Nova\Metrics;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class PurchasesPerProduct extends Partition
{
    public function calculate(NovaRequest $request)
    {
        return $this->count(
            $request,
            Purchase::query()
                ->whereHas('receipt', function (Builder $query): void {
                    $query->where('amount', '!=', 0);
                })
                ->select(['purchases.*', 'purchasables.product_id'])
                ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id')
                ->orderByDesc('aggregate'),
            'product_id'
        )->label(function ($value) {
            return Product::find($value)->title;
        });
    }

    public function uriKey()
    {
        return 'purchases-per-product';
    }
}
