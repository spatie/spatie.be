<?php

namespace App\Nova\Metrics;

use App\Domain\Shop\Models\Purchase;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class Earnings extends Trend
{
    public function calculate(NovaRequest $request)
    {
        return $this
            ->sumByDays(
                $request,
                Purchase::where('earnings', '!=', '0'),
                'earnings'
            )
            ->dollars()
            ->showSumValue();
    }

    public function ranges()
    {
        return [
            10 => '10 Days',
            30 => '30 Days',
            60 => '60 Days',
            90 => '90 Days',
        ];
    }

    public function uriKey()
    {
        return 'purchases';
    }
}
