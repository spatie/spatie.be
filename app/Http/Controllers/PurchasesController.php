<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PurchasesController
{
    public function __invoke(Request $request)
    {
        $courses = $request->user()
            ->assignmentsWithoutRenewals()
            ->with(['purchasable.product', 'purchasable.media'])
            ->whereHas('purchasable', fn(Builder $query) => $query
                ->whereHas('series')
                ->orWhereHas('media', fn(Builder $query) => $query->where('collection_name', 'downloads'))
            )
            ->get()
            ->unique('purchasable_id');

        $applications = $request->user()
            ->assignmentsWithoutRenewals()
            ->with(['purchasable.product', 'purchasable.media', 'licenses.activations'])
            ->whereHas('licenses')
            ->get()
            ->groupBy('purchasable.product_id');

        return view('front.profile.purchases', compact('courses', 'applications'));
    }
}
