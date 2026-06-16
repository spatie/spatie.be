<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchasesController
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $courses = $user
            ->assignmentsWithoutRenewals()
            ->with(['purchase.user', 'purchasable.product', 'purchasable.media'])
            ->whereHas(
                'purchasable',
                fn (Builder $query) => $query
                    ->whereHas('series')
                    ->orWhereHas('media', fn (Builder $query) => $query->where('collection_name', 'downloads'))
            )
            ->get()
            ->unique('purchasable_id')
            ->sortBy('purchasable.product.title');

        $applications = $user
            ->assignmentsWithoutRenewals()
            ->with(['purchase.user', 'purchasable.product', 'purchasable.media', 'licenses.activations'])
            ->whereHas('licenses')
            ->get()
            ->sortBy('purchasable.product.title')
            ->groupBy('purchasable.product_id');

        $assignedAwayPurchases = $user
            ->purchasesWithoutRenewals()
            ->with([
                'assignments' => fn ($query) => $query
                    ->where('user_id', '!=', $user->id)
                    ->with(['purchasable.product', 'user']),
                'receipt',
            ])
            ->whereHas('assignments', fn (Builder $query) => $query->where('user_id', '!=', $user->id))
            ->get()
            ->sortByDesc(fn (Purchase $purchase) => $purchase->receipt->paid_at ?? $purchase->created_at);

        return view('front.profile.purchases', compact('courses', 'applications', 'assignedAwayPurchases'));
    }
}
