<?php

namespace App\Nova\Filters;

use App\Domain\Shop\Models\Purchasable;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class PurchasableFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('purchasable_id', $value);
    }

    public function options(Request $request)
    {
        return Purchasable::all()
            ->mapWithKeys(fn (Purchasable $purchasable) => [$purchasable->getFullTitle() => $purchasable->id])
            ->sortKeys()
            ->toArray();
    }
}
