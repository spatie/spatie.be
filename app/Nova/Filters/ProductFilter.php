<?php

namespace App\Nova\Filters;

use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class ProductFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('product_id', $value);
    }

    public function options(Request $request)
    {
        return Product::pluck('id', 'title')->toArray();
    }
}
