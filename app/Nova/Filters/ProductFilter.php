<?php

namespace App\Nova\Filters;

use App\Domain\Shop\Models\Product;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where('product_id', $value);
    }

    public function options(NovaRequest $request)
    {
        return Product::pluck('id', 'title')->toArray();
    }
}
