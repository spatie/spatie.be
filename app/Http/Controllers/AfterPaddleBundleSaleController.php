<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;
use Illuminate\Http\Request;

class AfterPaddleBundleSaleController
{
    public function __invoke(Request $request, Product $product, Bundle $bundle)
    {
        sleep(4);

        Referrer::forgetActive();

        session()->flash('sold_purchasable', $bundle);

        if (current_user()) {
            session()->flash('latest_assignment', current_user()->assignments()->where('purchasable_id', $bundle->purchasables->first()->id)->latest()->first());
        }

        flash()->success('Purchase successful!');

        return redirect()->route('purchases');
    }
}
