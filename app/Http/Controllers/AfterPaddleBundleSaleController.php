<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Referrer;
use Illuminate\Http\Request;

class AfterPaddleBundleSaleController
{
    public function __invoke(Request $request, Bundle $bundle)
    {
        sleep(4);

        Referrer::forgetActive();

        session()->flash('sold_purchasable', $bundle->purchasables->first());

        if (current_user()) {
            session()->flash('latest_purchase', current_user()->purchases()->latest()->first());
        }

        flash()->success('Purchase successful!');

        return redirect()->route('purchases');
    }
}
