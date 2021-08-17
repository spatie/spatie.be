<?php

namespace App\Http\Controllers;

use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\PurchaseAssignment;
use Illuminate\Http\Request;

class PurchasesController
{
    public function __invoke(Request $request)
    {
        $purchasesPerProduct = $request->user()
            ->assignments()
            ->with(['purchasable.product'])
            ->get()
            ->flatMap(function (PurchaseAssignment $assignment) {
                return [[
                    'product_id' => $assignment->purchasable->product_id,
                    'purchase' => $assignment->purchase,
                    'purchasable' => $assignment->purchasable,
                    'product' => $assignment->purchasable->product,
                ]];
            })->mapToGroups(fn(array $data) => [$data['product_id'] => [
                'purchase' => $data['purchase'],
                'purchasable' => $data['purchasable'],
                'product' => $data['product'],
            ]]);

        return view('front.profile.purchases', compact('purchasesPerProduct'));
    }
}
