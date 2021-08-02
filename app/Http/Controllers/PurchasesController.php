<?php

namespace App\Http\Controllers;

use App\Models\Purchasable;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchasesController
{
    public function __invoke(Request $request)
    {
        $purchasesPerProduct = $request->user()
            ->purchasesWithoutRenewals()
            ->with(['purchasable', 'bundle'])
            ->get()
            ->flatMap(function (Purchase $purchase) {
                if ($purchase->bundle) {
                    return $purchase->bundle->purchasables->map(function (Purchasable $purchasable) use ($purchase) {
                        return [
                            'product_id' => $purchasable->product_id,
                            'purchase' => $purchase,
                            'product' => $purchasable->product,
                        ];
                    });
                }

                return [[
                    'product_id' => $purchase->purchasable->product_id,
                    'purchase' => $purchase,
                    'product' => $purchase->purchasable->product,
                ]];
            })->mapToGroups(fn(array $data) => [$data['product_id'] => [
                'purchase' => $data['purchase'],
                'product' => $data['product'],
            ]]);

        return view('front.profile.purchases', compact('purchasesPerProduct'));
    }
}
