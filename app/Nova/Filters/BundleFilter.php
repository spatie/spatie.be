<?php

namespace App\Nova\Filters;

use App\Domain\Shop\Models\Bundle;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class BundleFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where('bundle_id', $value);
    }

    public function options(NovaRequest $request)
    {
        return Bundle::pluck('id', 'title')->toArray();
    }
}
