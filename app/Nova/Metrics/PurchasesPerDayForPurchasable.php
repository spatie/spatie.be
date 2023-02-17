<?php

namespace App\Nova\Metrics;

use App\Domain\Shop\Models\Purchase;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class PurchasesPerDayForPurchasable extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this
            ->countByDays($request, Purchase::query()->where('purchasable_id', $request->resourceId))
            ->showSumValue();
    }

    /**
     * Get the ranges available for the metric.
     */
    public function ranges(): array
    {
        return [
            30 => __('30 Days'),
            60 => __('60 Days'),
            90 => __('90 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey(): string
    {
        return 'purchases-per-day';
    }
}
