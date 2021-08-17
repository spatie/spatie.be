<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\PurchaseAssignment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PurchasesController
{
    public function __invoke(Request $request)
    {
        $purchases = $request->user()
            ->purchasesWithoutRenewals()
            ->with(['bundle', 'purchasable.product', 'assignments'])
            ->get();

        $assignments = $request->user()
            ->assignmentsWithoutRenewals()
            ->with(['purchasable.product', 'licenses'])
            ->whereNotIn('purchase_id', $purchases->pluck('id'))
            ->get()
            ->unique('purchasable.id')
            ->groupBy(fn (PurchaseAssignment $assignment) => $assignment->purchasable->product->title);

        return view('front.profile.purchases', compact('purchases', 'assignments'));
    }
}
