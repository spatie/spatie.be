<?php

namespace App\Nova\Filters;

use App\Models\Series;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SeriesFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('series_id', $value);
    }

    public function options(Request $request)
    {
        return Series::pluck('id', 'title');
    }
}
