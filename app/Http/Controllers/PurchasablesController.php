<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchasable;
use Illuminate\Http\Request;

class PurchasablesController
{
    public function afterSale(Request $request, Product $product, Purchasable $purchasable)
    {
        sleep(3);

        if ($purchasable->analytics_goal_id) {
            session()->flash('completed_goal_id', $purchasable->analytics_goal_id);
            session()->flash('completed_goal_earnings', $purchasable->getAverageEarnings());
        }

        flash()->success('Purchase successful');

        return redirect()->route('products.show', $product);
    }
}
