<?php

namespace App\Nova\Metrics;

use App\Models\Product;
use App\Models\Purchase;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class PurchasesPerProduct extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count(
            $request,
            Purchase::query()
                ->select('purchases.*', 'purchasables.product_id')
                ->join('purchasables', 'purchasables.id', '=', 'purchases.purchasable_id'),
            'product_id'
        )->label(function ($value) {
            return Product::find($value)->title;
        });
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'purchases-per-product';
    }
}
