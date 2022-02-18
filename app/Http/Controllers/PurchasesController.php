<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PurchasesController
{
    public function __invoke(Request $request)
    {
        $courses = $request->user()
            ->assignmentsWithoutRenewals()
            ->with(['purchasable.product', 'purchasable.media'])
            ->whereHas(
                'purchasable',
                fn (Builder $query) => $query
                ->whereHas('series')
                ->orWhereHas('media', fn (Builder $query) => $query->where('collection_name', 'downloads'))
            )
            ->get()
            ->unique('purchasable_id')
            ->sortBy('purchasable.product.title');

        $applications = $request->user()
            ->assignmentsWithoutRenewals()
            ->with(['purchasable.product', 'purchasable.media', 'licenses.activations'])
            ->whereHas('licenses')
            ->get()
            ->sortBy('purchasable.product.title')
            ->groupBy('purchasable.product_id');

        return view('front.profile.purchases', compact('courses', 'applications'));
    }
}
