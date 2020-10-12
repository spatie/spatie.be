<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchasable;
use Illuminate\Http\Request;

class AfterPaddleSaleController
{
    public function __invoke(Request $request, Product $product, Purchasable $purchasable)
    {
        sleep(3);

        session()->flash('sold_purchasable', $purchasable);

        flash()->success('Purchase successful');

        return redirect()->route('products.show', $product);
    }
}
