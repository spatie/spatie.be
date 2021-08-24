<?php

namespace App\Nova\Filters;

use App\Domain\Shop\Models\Bundle;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class BundleFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('bundle_id', $value);
    }

    public function options(Request $request)
    {
        return Bundle::pluck('id', 'title')->toArray();
    }
}
