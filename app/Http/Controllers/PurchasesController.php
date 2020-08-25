<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchasesController
{
    public function __invoke(Request $request)
    {
        $purchasesPerProduct = $request->user()
            ->purchasesWithoutRenewals()
            ->get()
            ->groupBy('purchasable.product_id');

        return view('front.profile.purchases', compact('purchasesPerProduct'));
    }
}
