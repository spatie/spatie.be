<?php

namespace App\Nova\Filters;

use App\Models\Series;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class SeriesFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where('series_id', $value);
    }

    public function options(NovaRequest $request)
    {
        return Series::pluck('id', 'title')->toArray();
    }
}
