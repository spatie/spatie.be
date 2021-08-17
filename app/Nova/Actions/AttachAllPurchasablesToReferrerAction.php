<?php

namespace App\Nova\Actions;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class AttachAllPurchasablesToReferrerAction extends Action
{
    public $name = 'Attach all purchasables';

    public function handle(ActionFields $fields, Collection $models)
    {
        $purchasables = Purchasable::all();

        $models->each(function (Referrer $referrer) use ($purchasables) {
            $referrer->purchasables()->sync($purchasables);
        });

        Action::message('All purchables added to referrer!');
    }
}
