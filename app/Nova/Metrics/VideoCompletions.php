<?php

namespace App\Nova\Metrics;

use App\Models\VideoCompletion;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class VideoCompletions extends Trend
{
    public function calculate(NovaRequest $request)
    {
        return $this
            ->countByDays($request, VideoCompletion::class)
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
        return 'video-completions';
    }
}
