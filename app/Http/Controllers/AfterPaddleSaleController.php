<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchasable;
use App\Models\Referrer;
use Illuminate\Http\Request;

class AfterPaddleSaleController
{
    public function __invoke(Request $request, Product $product, Purchasable $purchasable)
    {
        sleep(4);

        Referrer::forgetActive();

        session()->flash('sold_purchasable', $purchasable);

        session()->flash('latest_purchase', current_user()->purchases()->latest()->first());

        flash()->success('Purchase successful!');

        return redirect()->route('products.show', $product);
    }
}
